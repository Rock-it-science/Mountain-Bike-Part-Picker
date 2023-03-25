from bs4 import BeautifulSoup
import urllib3
from pprint import pprint

class Scraper:
    def __init__(self, http=None):
        if http is None: self.http = urllib3.PoolManager()
        else: self.http = http
    
    """ Utilities """
    def scrape(self, url: str) -> BeautifulSoup:
        """
        Basic scrape function. Gets beautiful soup object from url.

        Args:
         - url: URL to webpage to scrape
        """

        resp = self.http.request('GET', url)
        document = resp.data.decode('utf-8')
        soup = BeautifulSoup(document, 'html.parser')
        return soup
    

    """ Functions """
    def scrapeProduct(self, url: str) -> dict:
        """
        Given link to product page, scrape for product data.

        Args:
         - url: URL to product page to scrape
        """
        return


    def scrapeCategory(self, url: str, domain: str) -> list:
        """
        Given link to a category page (containing direct links to products), get links to individual products

        Args:
         - url: URL to category page to scrape
        
        Return:
         - List of dicts with title, and link
        """
        soup = self.scrape(url)
        
        products = []
        
        # Get all links and product titles
        # print(soup.body)
        # with open('body.html', 'w', encoding='utf-8') as f:
        #     f.write(str(soup.body))
        for a in soup.find_all('a', class_='product-card'): # This class is specific to worldwide cyclery
            href = a.get('href')
            if href is not None:
                if href[0] == '/': # If link starts with a slash, it is a relative link so add domain in front of it to make FQDN
                    href = domain + href
                title = a.find('img').get('alt')
                products.append([title, href])

        return products


s = Scraper()
products = s.scrapeCategory('https://www.worldwidecyclery.com/collections/forks', 'https://www.worldwidecyclery.com')

