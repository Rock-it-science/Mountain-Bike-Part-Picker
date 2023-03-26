from bs4 import BeautifulSoup
import urllib3
from pprint import pprint
from tqdm import tqdm

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
    def WWCscrapeCategory(self, url: str, domain: str, page: int = 1) -> list:
        """
        Given link to a category page (containing direct links to products), get links to individual products

        Args:
         - url: URL to category page to scrape
         - domain: domain URL
         - page (optional, default 1): page to scrape
        
        Return:
         - List of lists containing title and link for each product
        """

        print(f"Page {page}")
        soup = self.scrape(f'{url}?page={page}')
        
        products = []
        
        # Get all links and product titles
        # with open('body.html', 'w', encoding='utf-8') as f:
        #     f.write(str(soup.body))
        for a in tqdm(soup.find_all('a', class_='product-card')): # This class is specific to worldwide cyclery
            href = a.get('href')
            if href is not None:
                if href[0] == '/': # If link starts with a slash, it is a relative link so add domain in front of it to make FQDN
                    href = domain + href
                title = a.find('img').get('alt')
                products.append([title, href])
        if len(products) > 0:
            products += self.scrapeCategory(url, domain, page+1)
        return products


    def SramProduct(self, product_url: str) -> dict:
        """
            Given URL to product page, get product info
            Write raw HTML of product page
        """


    def SramSubcategory(self, subcategory_url: str) -> list:
        """
            Given URL to subcategory page, get product page URLss
        """


    def SramCategory(self, url: str) -> list:
        """
            Given URL to category page, get subcategory pages and subsequently product pages
        """
        soup = self.scrape(url)
        subcategories = ...
        
        product_urls = []
        for subcategory in subcategories:
            product_urls += self.SramSubcategory(subcategory)

    def scrapeProduct(self, url: str) -> dict:
        """
        Given link to product page, scrape for product data.

        Args:
         - url: URL to product page to scrape
        """

        return


s = Scraper()
# products = s.WWCscrapeCategory('https://www.worldwidecyclery.com/collections/forks', 'https://www.worldwidecyclery.com')
pprint(products)
