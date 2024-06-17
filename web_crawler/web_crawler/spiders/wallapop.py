import scrapy
import json
import logging
import re
from scrapy_selenium import SeleniumRequest
from scrapy.selector import Selector
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium import webdriver
from datetime import datetime

from selenium.webdriver.chrome.options import Options


class WallapopSpider(scrapy.Spider):
    name = "wallapop"

    def start_requests(self):
        self.item_data = []
        url = "https://es.wallapop.com/app/search?category_ids=12465&object_type_ids=9562&keywords=omega%20watch&latitude=40.41956&longitude=-3.69196&filters_source=quick_filters"
        yield SeleniumRequest(url=url, callback=self.parse)

    def parse(self, response):
        # Obtén una instancia del controlador de Selenium

        options = webdriver.ChromeOptions()
        options.add_argument("headless")
        driver = webdriver.Chrome(options=options)

        # Navega a la URL
        driver.get(response.url)

        # Espera a que aparezcan los elementos con la clase especificada
        wait = WebDriverWait(driver, 15)
        wait.until(
            EC.presence_of_all_elements_located(
                (By.CSS_SELECTOR, ".ItemCardList__item")
            )
        )

        items = driver.find_elements(By.CSS_SELECTOR, ".ItemCardList__item")

        parsed_items = 0

        for item in items:
            item_text = item.get_attribute("title")
            item_url = item.get_attribute("href")

            yield SeleniumRequest(
                url=item_url, callback=self.parse_item, meta={"item_text": item_text}
            )
            parsed_items += 1
            if parsed_items >= 16:
                break
                
        driver.quit()


    def parse_item(self, response):
        options = webdriver.ChromeOptions()
        options.add_argument("headless")
        driver = webdriver.Chrome(options=options)

        driver.get(response.url)

        wait = WebDriverWait(driver, 15)
        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, ".pb-5")))

        pb5_element = driver.find_element(By.CSS_SELECTOR, ".pb-5")

        image = pb5_element.find_element(By.TAG_NAME, "img")  
        image_src = image.get_attribute("src")

        price = pb5_element.find_element(
            By.CSS_SELECTOR, ".item-detail-price_ItemDetailPrice--standard__TxPXr"
        ).text
        price = price.replace("€", "")

        title = pb5_element.find_element(
            By.CSS_SELECTOR, "h1.item-detail_ItemDetail__title__wcPRl"
        ).text

    
        item_url = response.url

        match = re.search(r"(\d+)$", item_url)
        identificador = match.group(1) if match else None

        views_div = pb5_element.find_element(
            By.CSS_SELECTOR, "div.mr-3.d-flex.align-items-center"
        )

        views = views_div.find_element(By.TAG_NAME, "span").text

        location_div = pb5_element.find_element(
            By.CSS_SELECTOR, "div.d-flex.item-detail-location_ItemDetailLocation___QiCU"
        )

        location = location_div.find_element(By.TAG_NAME, "a").text
        fecha_guardado = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        item_data = {
            "title": title,
            "image_src": image_src,
            "price": price,
            "location": location,
            "views": views,
            "url": item_url,
            "identificador": identificador,
            'tipo':2,
            'fecha_guardado' : fecha_guardado,

        }

        self.item_data.append(item_data)

        driver.quit()

    def close(self, reason):
        if reason == "finished":
            with open("wallapop.json", "w", encoding="utf-8") as f:
                json.dump(self.item_data, f, indent=4, ensure_ascii=False)
