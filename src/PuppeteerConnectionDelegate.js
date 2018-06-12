'use strict';

const puppeteer = require('puppeteer'),
    {Browser} = require('puppeteer/lib/Browser'),
    {ConnectionDelegate} = require('@nesk/rialto');

/**
 * Handle the requests of a connection to control Puppeteer.
 */
class PuppeteerConnectionDelegate extends ConnectionDelegate {
    /**
     * Constructor.
     */
    constructor() {
        super();

        this.browsers = new Set;

        this.addSignalEventListeners();
    }

    /**
     * @inheritdoc
     */
    async handleInstruction(instruction, responseHandler, errorHandler) {
        const instructionName = instruction.name();

        instruction.setDefaultResource(puppeteer);

        let value = null;

        try {
            value = await instruction.execute();
        } catch (error) {
            if (instruction.shouldCatchErrors()) {
                return errorHandler(error);
            }

            throw error;
        }

        if (value instanceof Browser) {
            this.browsers.add(value);
        }

        responseHandler(value);
    }

    /**
     * Listen for process signal events.
     *
     * @protected
     */
    addSignalEventListeners() {
        for (let eventName of ['SIGINT', 'SIGTERM', 'SIGHUP']) {
            process.on(eventName, () => {
                this.closeAllBrowsers();
                process.exit();
            });
        }
    }

    /**
     * Close all the browser instances when the process exits.
     *
     * Calling this method before exiting Node is mandatory since Puppeteer doesn't seem to handle that properly.
     *
     * @protected
     */
    closeAllBrowsers() {
        for (let browser of this.browsers.values()) {
            browser.close();
        }
    }
}

module.exports = PuppeteerConnectionDelegate;
