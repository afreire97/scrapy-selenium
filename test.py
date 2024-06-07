import re

urls = [
    "https://es.wallapop.com/item/swatch-x-mega-mission-to-moon-watch-new-1016300426",
    "https://es.wallapop.com/item/swok-x-omega-moon-watch-1010447488"
]

regex = r"(\d+)$"

for url in urls:
    match = re.search(regex, url)
    if match:
        print("URL:", url)
        print("Identificador:", match.group(1))
    else:
        print("No se encontró ningún identificador en la URL:", url)
