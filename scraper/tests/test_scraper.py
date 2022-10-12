import json
import pytest
import unittest

from scraper import scraper

@pytest.fixture
def scrape(url: str):
    docs = {}
    with open('test_docs.json', 'r') as f:
        docs = json.load(f)
    yield docs[url]

class TestScraper:
    s = scraper.Scraper()

    def test_scrape_local(self, scrape): # Test a local document
        test_soup = scrape('title_only')
        
        assert True
