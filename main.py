import urllib.request
import json
import smtplib
from email.message import EmailMessage
import time
from datetime import datetime

class DatabaseDownloader:
    def __init__(self):
        self.api_url = "https://[yourapiurl].php"
        
    def download_database(self):
        headers = {"X-API-KEY": "yourapikey"}
        req = urllib.request.Request(self.api_url, headers=headers)
        response = urllib.request.urlopen(req)
        data = response.read()
        with open(f'database_backup_{datetime.now().strftime("%Y_%m_%d")}.sql', 'wb') as f:
            f.write(data)    
              
        
        
if __name__ == "__main__":
    downloader = DatabaseDownloader()
    while True:
        downloader.download_database()
        time.sleep(3*24*60*60)  # Sleep for 3 days
