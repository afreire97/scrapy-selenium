import scrapy
import re

from scrapy_selenium import SeleniumRequest
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import json
class VintedSpider(scrapy.Spider):
    name = "vinted"

    def start_requests(self):
        self.item_data = []
        url = "https://www.vinted.es/catalog?search_text=watch&order=newest_first&brand_ids[]=194842&brand_ids[]=7467552"  # URL base
        yield SeleniumRequest(url=url, callback=self.parse)

    def parse(self, response):
    # Obtén una instancia del controlador de Selenium
        options = webdriver.ChromeOptions()
        options.add_argument('headless')
        driver = webdriver.Chrome(options=options)

        # Navega a la URL
        driver.get(response.url)

        # Espera a que aparezcan los elementos con la clase especificada
        wait = WebDriverWait(driver, 15)
        feed_items = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, '.feed-grid__item-content')))

        parsed_items = 0

        # Itera sobre los elementos y extrae los datos
        for item in feed_items:
            url = item.find_element(By.CSS_SELECTOR, 'a.new-item-box__overlay--clickable').get_attribute('href')
            yield SeleniumRequest(url=url, callback=self.parse_item)
            parsed_items += 1
            if parsed_items >= 16:
                break
        # Cierra el controlador de Selenium
        driver.quit()

    def parse_item(self, response):
        options = webdriver.ChromeOptions()
        options.add_argument('headless')
        driver = webdriver.Chrome(options=options)

        driver.get(response.url)

        brand_element = driver.find_element(By.CSS_SELECTOR, 'a.inverse.u-disable-underline-without-hover')

        brand = brand_element.find_element(By.TAG_NAME, 'span').text

        location_element = driver.find_element(By.CSS_SELECTOR, 'div[data-testid="item-details-location"] div.details-list__item-value')

        location = location_element.text
        view_count_element = driver.find_element(By.CSS_SELECTOR, 'div[data-testid="item-details-view_count"] div.details-list__item-value')
        
        
        price_container_element = driver.find_element(By.CSS_SELECTOR, 'div[data-testid="item-sidebar-price-container"]')
        price_element = price_container_element.find_element(By.CSS_SELECTOR, 'div.u-flexbox.u-align-items-center[data-testid="item-price"]')

        price_text_element = price_element.find_element(By.TAG_NAME, 'h3')
        price = price_text_element.text
        price = price.replace('€', '')

          
        
        
        image_div = driver.find_element(By.CSS_SELECTOR, 'div[data-testid="item-photo-1"]')
        image_src = image_div.find_element(By.TAG_NAME, 'img').get_attribute('src')

        views = view_count_element.text

        item_url = response.url

        match = re.search(r'items/(\d+)-', item_url)
        if match:
            identificador = match.group(1)
        else:
            identificador = None


        title_element = driver.find_element(By.CSS_SELECTOR, 'div[itemprop="name"]')

        title = title_element.find_element(By.TAG_NAME, 'h2').text

        # Agregar el objeto a self.item_data
        self.item_data.append({
            
            'title': title,
            'image_src' : image_src,
            'price': price,
            'brand': brand,
            'location': location,
            'views' : views,
            'url': item_url,
            'identificador': identificador
        })

        # Agregar el objeto a self.item_data

        # Cierra el controlador de Selenium
        driver.quit()
    def close(self, reason):
        if reason == 'finished':
            with open('vinted.json', 'w', encoding='utf-8') as f:
                json.dump(self.item_data, f, indent=4, ensure_ascii=False)