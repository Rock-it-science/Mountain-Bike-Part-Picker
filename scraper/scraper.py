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
        


    def scrapeCategory(self, url: str) -> list:
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
        #    Titles are often nested in a desdendant tag
        for a in soup.find_all('a'):
            href = a.get('href')
            title = ""
            for child in a.select('snize-title'):
                print(child)
                title = child.string
            products.append([title, href])

        return products


s = Scraper()
s.scrapeCategory('https://www.worldwidecyclery.com/collections/forks')
