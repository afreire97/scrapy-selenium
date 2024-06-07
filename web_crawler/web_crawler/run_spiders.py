import sys
import os
from scrapy.crawler import CrawlerProcess
from scrapy.utils.project import get_project_settings

# Añadir la carpeta del proyecto al sys.path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from spiders import WallapopSpider, VintedSpider

def main():
    settings = get_project_settings()
    process = CrawlerProcess(settings)
    
    process.crawl(WallapopSpider)
    process.crawl(VintedSpider)

    process.start()  # el script se bloqueará aquí hasta que todos los trabajos de crawling hayan terminado

if __name__ == '__main__':
    main()
