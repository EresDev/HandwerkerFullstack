'use strict';

const puppeteer = require('puppeteer');

beforeEach(() => {


    (async () => {


    })();
});

test('Password and confirm password fields must be equal before submission', () => {

    (async () => {
        const browser = await puppeteer.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox'
            ]
        });

        const page = await browser.newPage();

        await page.goto('https://example.com');
        await page.screenshot({path: 'example.png'});

        await browser.close();
    })();
});

//
// describe('Google', () => {
//     beforeAll(async () => {
//         await page.goto('https://google.com');
//     });
//
//     it('should be titled "Google"', async () => {
//         await expect(page.title()).resolves.toMatch('Google');
//     });
// });