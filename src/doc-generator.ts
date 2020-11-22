import * as ts from 'typescript';
const yargs = require('yargs/yargs');
const { hideBin } = require('yargs/helpers');

type ObjectMemberAsJson = { [key: string]: string; }

type ObjectMembersAsJson = {
    properties: ObjectMemberAsJson,
    getters: ObjectMemberAsJson,
    methods: ObjectMemberAsJson,
}

type ClassAsJson = { name: string } & ObjectMembersAsJson
type MemberContext = 'class'|'literal'
type TypeContext = 'methodReturn'

class TypeNotSupportedError extends Error {
    constructor(message?: string) {
        super(message || 'This type is currently not supported.');
    }
}

interface SupportChecker {
    supportsMethodName(methodName: string): boolean;
}

class JsSupportChecker {
    supportsMethodName(methodName: string): boolean {
        return true;
    }
}

class PhpSupportChecker {
    supportsMethodName(methodName: string): boolean {
        return !methodName.includes('$');
    }
}

interface DocumentationFormatter {
    formatProperty(name: string, type: string, context: MemberContext): string
    formatGetter(name: string, type: string): string
    formatAnonymousFunction(parameters: string, returnType: string): string
    formatFunction(name: string, parameters: string, returnType: string): string
    formatParameter(name: string, type: string, isVariadic: boolean, isOptional: boolean): string
    formatTypeAny(): string
    formatTypeUnknown(): string
    formatTypeVoid(): string
    formatTypeUndefined(): string
    formatTypeNull(): string
    formatTypeBoolean(): string
    formatTypeNumber(): string
    formatTypeString(): string
    formatTypeReference(type: string): string
    formatGeneric(parentType: string, argumentTypes: string[], context?: TypeContext): string
    formatQualifiedName(left: string, right: string): string
    formatIndexedAccessType(object: string, index: string): string
    formatLiteralType(value: string): string
    formatUnion(types: string[]): string
    formatIntersection(types: string[]): string
    formatObject(members: string[]): string
    formatArray(type: string): string
}

class JsDocumentationFormatter implements DocumentationFormatter {
    formatProperty(name: string, type: string, context: MemberContext): string {
        return `${name}: ${type}`;
    }

    formatGetter(name: string, type: string): string {
        return `${name}: ${type}`;
    }

    formatAnonymousFunction(parameters: string, returnType: string): string {
        return `(${parameters}) => ${returnType}`;
    }

    formatFunction(name: string, parameters: string, returnType: string): string {
        return `${name}(${parameters}): ${returnType}`;
    }

    formatParameter(name: string, type: string, isVariadic: boolean, isOptional: boolean): string {
        return `${isVariadic ? '...' : ''}${name}${isOptional ? '?' : ''}: ${type}`;
    }

    formatTypeAny(): string {
        return 'any';
    }

    formatTypeUnknown(): string {
        return 'unknown';
    }

    formatTypeVoid(): string {
        return 'void';
    }

    formatTypeUndefined(): string {
        return 'undefined';
    }

    formatTypeNull(): string {
        return 'null';
    }

    formatTypeBoolean(): string {
        return 'boolean';
    }

    formatTypeNumber(): string {
        return 'number';
    }

    formatTypeString(): string {
        return 'string';
    }

    formatTypeReference(type: string): string {
        return type;
    }

    formatGeneric(parentType: string, argumentTypes: string[], context?: TypeContext): string {
        return `${parentType}<${argumentTypes.join(', ')}>`;
    }

    formatQualifiedName(left: string, right: string): string {
        return `${left}.${right}`;
    }

    formatIndexedAccessType(object: string, index: string): string {
        return `${object}[${index}]`;
    }

    formatLiteralType(value: string): string {
        return `'${value}'`;
    }

    formatUnion(types: string[]): string {
        return types.join(' | ');
    }

    formatIntersection(types: string[]): string {
        return types.join(' & ');
    }

    formatObject(members: string[]): string {
        return `{ ${members.join(', ')} }`;
    }

    formatArray(type: string): string {
        return `${type}[]`;
    }
}

class PhpDocumentationFormatter implements DocumentationFormatter {
    static readonly allowedJsClasses = ['Promise', 'Record', 'Map'];

    constructor(
        private readonly resourcesNamespace: string,
        private readonly resources: string[],
    ) {}

    formatProperty(name: string, type: string, context: MemberContext): string {
        return context === 'class'
            ? `${type} ${name}`
            : `${name}: ${type}`;
    }

    formatGetter(name: string, type: string): string {
        return `${type} ${name}`;
    }

    formatAnonymousFunction(parameters: string, returnType: string): string {
        return `callable(${parameters}): ${returnType}`;
    }

    formatFunction(name: string, parameters: string, returnType: string): string {
        return `${returnType} ${name}(${parameters})`;
    }

    formatParameter(name: string, type: string, isVariadic: boolean, isOptional: boolean): string {
        if (isVariadic && type.endsWith('[]')) {
            type = type.slice(0, -2);
        }

        const defaultValue = isOptional ? ' = null' : '';
        return `${type} ${isVariadic ? '...' : ''}\$${name}${defaultValue}`;
    }

    formatTypeAny(): string {
        return 'mixed';
    }

    formatTypeUnknown(): string {
        return 'mixed';
    }

    formatTypeVoid(): string {
        return 'void';
    }

    formatTypeUndefined(): string {
        return 'null';
    }

    formatTypeNull(): string {
        return 'null';
    }

    formatTypeBoolean(): string {
        return 'bool';
    }

    formatTypeNumber(): string {
        return 'float';
    }

    formatTypeString(): string {
        return 'string';
    }

    formatTypeReference(type: string): string {
        // Allow some specific JS classes to be used in phpDoc
        if (PhpDocumentationFormatter.allowedJsClasses.includes(type)) {
            return type;
        }

        // Prefix PHP resources with their namespace
        if (this.resources.includes(type)) {
            return `\\${this.resourcesNamespace}\\${type}`;
        }

        // If the type ends with "options" then convert it to an associative array
        if (/options$/i.test(type)) {
            return 'array<string, mixed>';
        }

        // Types ending with "Fn" are always callables or strings
        if (type.endsWith('Fn')) {
            return this.formatUnion(['callable', 'string']);
        }

        if (type === 'Function') {
            return 'callable';
        }

        if (type === 'PuppeteerLifeCycleEvent') {
            return 'string';
        }

        if (type === 'Serializable') {
            return this.formatUnion(['int', 'float', 'string', 'bool', 'null', 'array']);
        }

        if (type === 'SerializableOrJSHandle') {
            return this.formatUnion([this.formatTypeReference('Serializable'), this.formatTypeReference('JSHandle')]);
        }

        if (type === 'HandleType') {
            return this.formatUnion([this.formatTypeReference('JSHandle'), this.formatTypeReference('ElementHandle')]);
        }

        return 'mixed';
    }

    formatGeneric(parentType: string, argumentTypes: string[], context?: TypeContext): string {
        // Avoid generics with "mixed" as parent type
        if (parentType === 'mixed') {
            return 'mixed';
        }

        // Unwrap promises for method return types
        if (context === 'methodReturn' && parentType === 'Promise' && argumentTypes.length === 1) {
            return argumentTypes[0];
        }

        // Transform Record and Map types to associative arrays
        if (['Record', 'Map'].includes(parentType) && argumentTypes.length === 2) {
            parentType = 'array';
        }

        return `${parentType}<${argumentTypes.join(', ')}>`;
    }

    formatQualifiedName(left: string, right: string): string {
        return `mixed`;
    }

    formatIndexedAccessType(object: string, index: string): string {
        return `mixed`;
    }

    formatLiteralType(value: string): string {
        return `'${value}'`;
    }

    private prepareUnionOrIntersectionTypes(types: string[]): string[] {
        // Replace "void" type by "null"
        types = types.map(type => type === 'void' ? 'null' : type)

        // Remove duplicates
        const uniqueTypes = new Set(types);
        return Array.from(uniqueTypes.values());
    }

    formatUnion(types: string[]): string {
        const result = this.prepareUnionOrIntersectionTypes(types).join('|');

        // Convert enums to string type
        if (/^('\w+'\|)*'\w+'$/.test(result)) {
            return 'string';
        }

        return result;
    }

    formatIntersection(types: string[]): string {
        return this.prepareUnionOrIntersectionTypes(types).join('&');
    }

    formatObject(members: string[]): string {
        return `array{ ${members.join(', ')} }`;
    }

    formatArray(type: string): string {
        return `${type}[]`;
    }
}

class DocumentationGenerator {
    constructor(
        private readonly supportChecker: SupportChecker,
        private readonly formatter: DocumentationFormatter,
    ) {}

    private hasModifierForNode(
        node: ts.Node,
        modifier: ts.KeywordSyntaxKind
    ): boolean {
        if (!node.modifiers) {
            return false;
        }

        return node.modifiers.some((node) => node.kind === modifier);
    }

    private isNodeAccessible(node: ts.Node): boolean {
        // @ts-ignore
        if (node.name && this.getNamedDeclarationAsString(node).startsWith('_')) {
            return false;
        }

        return (
            this.hasModifierForNode(node, ts.SyntaxKind.PublicKeyword) ||
            (!this.hasModifierForNode(node, ts.SyntaxKind.ProtectedKeyword) &&
            !this.hasModifierForNode(node, ts.SyntaxKind.PrivateKeyword))
        );
    }

    private isNodeStatic(node: ts.Node): boolean {
        return this.hasModifierForNode(node, ts.SyntaxKind.StaticKeyword);
    }

    public getClassDeclarationAsJson(node: ts.ClassDeclaration): ClassAsJson {
        return Object.assign(
            { name: this.getNamedDeclarationAsString(node) },
            this.getMembersAsJson(node.members, 'class'),
        );
    }

    private getMembersAsJson(members: ts.NodeArray<ts.NamedDeclaration>, context: MemberContext): ObjectMembersAsJson {
        const json: ObjectMembersAsJson = {
            properties: {},
            getters: {},
            methods: {},
        };

        for (const member of members) {
            if (!this.isNodeAccessible(member) || this.isNodeStatic(member)) {
                continue;
            }

            const name = member.name ? this.getNamedDeclarationAsString(member) : null;

            if (ts.isPropertySignature(member) || ts.isPropertyDeclaration(member)) {
                json.properties[name] = this.getPropertySignatureOrDeclarationAsString(member, context);
            } else if (ts.isGetAccessorDeclaration(member)) {
                json.getters[name] = this.getGetAccessorDeclarationAsString(member);
            } else if (ts.isMethodDeclaration(member)) {
                if (!this.supportChecker.supportsMethodName(name)) {
                    continue;
                }
                json.methods[name] = this.getSignatureDeclarationBaseAsString(member);
            }
        }

        return json;
    }

    private getPropertySignatureOrDeclarationAsString(
        node: ts.PropertySignature | ts.PropertyDeclaration,
        context: MemberContext
    ): string {
        const type = this.getTypeNodeAsString(node.type);
        const name = this.getNamedDeclarationAsString(node);
        return this.formatter.formatProperty(name, type, context);
    }

    private getGetAccessorDeclarationAsString(
        node: ts.GetAccessorDeclaration
    ): string {
        const type = this.getTypeNodeAsString(node.type);
        const name = this.getNamedDeclarationAsString(node);
        return this.formatter.formatGetter(name, type);
    }

    private getSignatureDeclarationBaseAsString(
        node: ts.SignatureDeclarationBase
    ): string {
        const name = node.name && this.getNamedDeclarationAsString(node);
        const parameters = node.parameters
            .map(parameter => this.getParameterDeclarationAsString(parameter))
            .join(', ');

        const returnType = this.getTypeNodeAsString(node.type, name ? 'methodReturn' : undefined);

        return name
            ? this.formatter.formatFunction(name, parameters, returnType)
            : this.formatter.formatAnonymousFunction(parameters, returnType);
    }

    private getParameterDeclarationAsString(node: ts.ParameterDeclaration): string {
        const name = this.getNamedDeclarationAsString(node);
        const type = this.getTypeNodeAsString(node.type);
        const isVariadic = node.dotDotDotToken !== undefined;
        const isOptional = node.questionToken !== undefined;
        return this.formatter.formatParameter(name, type, isVariadic, isOptional);
    }

    private getTypeNodeAsString(node: ts.TypeNode, context?: TypeContext): string {
        if (node.kind === ts.SyntaxKind.AnyKeyword) {
            return this.formatter.formatTypeAny();
        } else if (node.kind === ts.SyntaxKind.UnknownKeyword) {
            return this.formatter.formatTypeUnknown();
        } else if (node.kind === ts.SyntaxKind.VoidKeyword) {
            return this.formatter.formatTypeVoid();
        } else if (node.kind === ts.SyntaxKind.UndefinedKeyword) {
            return this.formatter.formatTypeUndefined();
        } else if (node.kind === ts.SyntaxKind.NullKeyword) {
            return this.formatter.formatTypeNull();
        } else if (node.kind === ts.SyntaxKind.BooleanKeyword) {
            return this.formatter.formatTypeBoolean();
        } else if (node.kind === ts.SyntaxKind.NumberKeyword) {
            return this.formatter.formatTypeNumber();
        } else if (node.kind === ts.SyntaxKind.StringKeyword) {
            return this.formatter.formatTypeString();
        } else if (ts.isTypeReferenceNode(node)) {
            return this.getTypeReferenceNodeAsString(node, context);
        } else if (ts.isIndexedAccessTypeNode(node)) {
            return this.getIndexedAccessTypeNodeAsString(node);
        } else if (ts.isLiteralTypeNode(node)) {
            return this.getLiteralTypeNodeAsString(node);
        } else if (ts.isUnionTypeNode(node)) {
            return this.getUnionTypeNodeAsString(node, context);
        } else if (ts.isIntersectionTypeNode(node)) {
            return this.getIntersectionTypeNodeAsString(node, context);
        } else if (ts.isTypeLiteralNode(node)) {
            return this.getTypeLiteralNodeAsString(node);
        } else if (ts.isArrayTypeNode(node)) {
            return this.getArrayTypeNodeAsString(node, context);
        } else if (ts.isFunctionTypeNode(node)) {
            return this.getSignatureDeclarationBaseAsString(node);
        } else {
            throw new TypeNotSupportedError();
        }
    }

    private getTypeReferenceNodeAsString(node: ts.TypeReferenceNode, context?: TypeContext): string {
        return this.getGenericTypeReferenceNodeAsString(node, context) || this.getSimpleTypeReferenceNodeAsString(node);
    }

    private getGenericTypeReferenceNodeAsString(node: ts.TypeReferenceNode, context?: TypeContext): string | null {
        if (!node.typeArguments || node.typeArguments.length === 0) {
            return null;
        }

        const parentType = this.getSimpleTypeReferenceNodeAsString(node);
        const argumentTypes = node.typeArguments.map((node) => this.getTypeNodeAsString(node));
        return this.formatter.formatGeneric(parentType, argumentTypes, context);
    }

    private getSimpleTypeReferenceNodeAsString(node: ts.TypeReferenceNode): string {
        return ts.isIdentifier(node.typeName)
            ? this.formatter.formatTypeReference(this.getIdentifierAsString(node.typeName))
            : this.getQualifiedNameAsString(node.typeName);
    }

    private getQualifiedNameAsString(node: ts.QualifiedName): string {
        const right = this.getIdentifierAsString(node.right);
        const left = ts.isIdentifier(node.left)
            ? this.getIdentifierAsString(node.left)
            : this.getQualifiedNameAsString(node.left);

        return this.formatter.formatQualifiedName(left, right);
    }

    private getIndexedAccessTypeNodeAsString(
        node: ts.IndexedAccessTypeNode
    ): string {
        const object = this.getTypeNodeAsString(node.objectType);
        const index = this.getTypeNodeAsString(node.indexType);
        return this.formatter.formatIndexedAccessType(object, index);
    }

    private getLiteralTypeNodeAsString(node: ts.LiteralTypeNode): string {
        if (node.literal.kind === ts.SyntaxKind.NullKeyword) {
            return this.formatter.formatTypeNull();
        } else if (node.literal.kind === ts.SyntaxKind.BooleanKeyword) {
            return this.formatter.formatTypeBoolean();
        } else if (ts.isLiteralExpression(node.literal)) {
            return this.formatter.formatLiteralType(node.literal.text);
        }
        throw new TypeNotSupportedError();
    }

    private getUnionTypeNodeAsString(node: ts.UnionTypeNode, context?: TypeContext): string {
        const types = node.types.map(typeNode => this.getTypeNodeAsString(typeNode, context));
        return this.formatter.formatUnion(types);
    }

    private getIntersectionTypeNodeAsString(node: ts.IntersectionTypeNode, context?: TypeContext): string {
        const types = node.types.map(typeNode => this.getTypeNodeAsString(typeNode, context));
        return this.formatter.formatIntersection(types);
    }

    private getTypeLiteralNodeAsString(node: ts.TypeLiteralNode): string {
        const members = this.getMembersAsJson(node.members, 'literal');
        const stringMembers = Object.values(members).map(Object.values);
        const flattenMembers = stringMembers.reduce((acc, val) => acc.concat(val), []);
        return this.formatter.formatObject(flattenMembers);
    }

    private getArrayTypeNodeAsString(node: ts.ArrayTypeNode, context?: TypeContext): string {
        const type = this.getTypeNodeAsString(node.elementType, context);
        return this.formatter.formatArray(type);
    }

    private getNamedDeclarationAsString(node: ts.NamedDeclaration): string {
        if (!ts.isIdentifier(node.name)) {
            throw new TypeNotSupportedError();
        }
        return this.getIdentifierAsString(node.name);
    }

    private getIdentifierAsString(node: ts.Identifier): string {
        return String(node.escapedText);
    }
}

const { argv } = yargs(hideBin(process.argv))
    .command('$0 <language> <definition-files...>')
    .option('resources-namespace', { type: 'string', default: '' })
    .option('resources', { type: 'array', default: [] })
    .option('pretty', { type: 'boolean', default: false })

let supportChecker, formatter;
switch (argv.language.toUpperCase()) {
    case 'JS':
        supportChecker = new JsSupportChecker();
        formatter = new JsDocumentationFormatter();
        break;
    case 'PHP':
        supportChecker = new PhpSupportChecker();
        formatter = new PhpDocumentationFormatter(argv.resourcesNamespace, argv.resources);
        break;
    default:
        console.error(`Unsupported "${argv.language}" language.`);
        process.exit(1);
}

const docGenerator = new DocumentationGenerator(supportChecker, formatter);
const program = ts.createProgram(argv.definitionFiles, {});
const classes = {};

for (const fileName of argv.definitionFiles) {
    const sourceFile = program.getSourceFile(fileName);

    ts.forEachChild(sourceFile, node => {
        if (ts.isClassDeclaration(node)) {
            const classAsJson = docGenerator.getClassDeclarationAsJson(node);
            classes[classAsJson.name] = classAsJson;
        }
    });
}

process.stdout.write(JSON.stringify(classes, null, argv.pretty ? 2 : null));
