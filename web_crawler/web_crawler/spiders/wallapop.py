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
        self.item_data = []
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

        parsed_items = 0

        # Itera sobre los elementos y extrae los datos
        for item in items:
            item_text = item.get_attribute('title')
            item_url = item.get_attribute('href')
        
            yield SeleniumRequest(url=item_url, callback=self.parse_item, meta={'item_text': item_text})
            parsed_items += 1
            if parsed_items >= 2:
                break

   
            

    def parse_item(self, response):
        options = webdriver.ChromeOptions()
        options.add_argument('headless')
        driver = webdriver.Chrome(options=options)

        driver.get(response.url)

        wait = WebDriverWait(driver, 15)
        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, '.pb-5')))

        # Obtener el elemento .pb-5
        pb5_element = driver.find_element(By.CSS_SELECTOR, '.pb-5')

        # Obtener las imágenes
        image = pb5_element.find_element(By.TAG_NAME, 'img')
        # valoracion = pb5_element.find_element(By.CSS_SELECTOR, 'item-detail-header_ItemDetailHeader__text--typoLowS__9JNQi').text

        # Obtener el precio
        price = pb5_element.find_element(By.CSS_SELECTOR, '.item-detail-price_ItemDetailPrice--standard__TxPXr').text
        price = price.replace('€', '')
        
        title = pb5_element.find_element(By.CSS_SELECTOR, 'h1.item-detail_ItemDetail__title__wcPRl').text


        description = pb5_element.find_element(By.CSS_SELECTOR, 'section.item-detail_ItemDetail__description__7rXXT').text




        item_url = response.url

        image_src = image.get_attribute('src')
        item_data = {
        'title': title,
        'image_src': image_src,
        'price': price,
        # 'valoracion': valoracion,
        'description': description,
        'url': item_url

        }


        self.item_data.append(item_data)
        
        driver.quit()


    def close(self, reason):
        if reason == 'finished':
            with open('wallapop.json', 'w') as f:
                json.dump(self.item_data, f, indent=4, ensure_ascii=False)        