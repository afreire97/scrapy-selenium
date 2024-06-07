# This package will contain the spiders of your Scrapy project
#
# Please refer to the documentation for information on how to create and manage
# your spiders.

from .wallapop import WallapopSpider
from .vinted import VintedSpider


__all__ = ['WallapopSpider', 'VintedSpider']
