import scrapy
import json
from scrapy_selenium import SeleniumRequest
from scrapy.selector import Selector
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium import webdriver
from selenium.webdriver.chrome.options import Options

class WallapopSpider(scrapy.Spider):
    name = "wallapop"

    def start_requests(self):
        url = "https://es.wallapop.com/app/search?filters_source=search_box&keywords=omega%20watch&longitude=-3.69196&latitude=40.41956"
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
        wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, '.ItemCardList__item')))

        # Obtén los elementos con la clase especificada
        items = driver.find_elements(By.CSS_SELECTOR, '.ItemCardList__item')

        # Itera sobre los elementos y extrae los datos
        data = []
        for item in items:
            item_text = item.get_attribute('title')
            item_url = item.get_attribute('href')
            data.append({
                'item_text': item_text,
                'item_url' : item_url,
            })

        with open('datos.json', 'w') as f:
            json.dump(data, f)