

import requests
import json

url = "https://coursesearch01.fcu.edu.tw/Service/Search.asmx/GetType2Result"

headers = {
    "Accept": "application/json, text/plain, */*",
    "Accept-Language":"en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7",
    "Content-Length":"405",
    "Content-Type":"application/json; charset=UTF-8",
    "Origin":"https://coursesearch03.fcu.edu.tw",
    "Referer":"https://coursesearch03.fcu.edu.tw/main.aspx?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODIzMzExMzd9.TR6nCyuHNjdgarwi8rR4I6ikNqFHHUpND_20DZcfFnQ",
    "sec-ch-ua":'"Chromium";v="112", "Microsoft Edge";v="112", "Not:A-Brand";v="99"',
    "sec-ch-ua-mobile":"?0",
    "sec-ch-ua-platform":'"Windows"'
}

data = {
  "baseOptions": {
    "lang": "cht",
    "year": 111,
    "sms": 2
  },
  "typeOptions": {
    "code": {
      "enabled": False,
      "value": ""
    },
    "weekPeriod": {
      "enabled": False,
      "week": "1",
      "period": "*"
    },
    "course": {
      "enabled": True,
      "value": ""
    },
    "teacher": {
      "enabled": False,
      "value": ""
    },
    "useEnglish": {
      "enabled": False
    },
    "useLanguage": {
      "enabled": False,
      "value": "01"
    },
    "specificSubject": {
      "enabled": False,
      "value": "1"
    },
    "courseDescription": {
      "enabled": False,
      "value": ""
    }
  }
}

response = requests.post(url, headers=headers, json=data)

print("Status Code", response.status_code)
#print("JSON Response ", response.json())


path = 'output2.json'
with open(path, 'w+', encoding='UTF-8') as f:
    f.write(str(response.json()["d"]))