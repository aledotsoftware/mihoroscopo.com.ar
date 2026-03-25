from playwright.sync_api import sync_playwright

def main():
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()
        page.goto("http://127.0.0.1:8000")

        # Wait for page load
        page.wait_for_timeout(1000)

        # Press Tab to focus the first element (which should be the skip link if added)
        page.keyboard.press("Tab")
        page.wait_for_timeout(500)

        page.screenshot(path="skip_link_tab.png", full_page=False)
        print("Captured skip_link_tab.png")

        browser.close()

if __name__ == "__main__":
    main()
