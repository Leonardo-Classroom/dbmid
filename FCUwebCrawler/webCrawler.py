

import requests
import json

url = "https://coursesearch01.fcu.edu.tw/Service/Search.asmx/GetType1Result"

headers = {
    "Accept": "application/json, text/plain, */*",
    "Accept-Language":"en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7",
    "Content-Length":"405",
    "Content-Type":"application/json; charset=UTF-8",
    "Origin":"https://coursesearch01.fcu.edu.tw",
    "Referer":"https://coursesearch01.fcu.edu.tw/main.aspx?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODIzMjU5NTJ9.kN-pj91MRfB0V1MfPEtpme6tXKiKP50I_7a4UxIxe9c",
    "sec-ch-ua":'"Chromium";v="112", "Microsoft Edge";v="112", "Not:A-Brand";v="99"',
    "sec-ch-ua-mobile":"?0",
    "sec-ch-ua-platform":'"Windows"'
}

data = {
    "baseOptions":{
        "lang":"cht",
        "year":111,
        "sms":2
    },
    "typeOptions":{
        "degree":"1",
        "deptId":"CI",
        "unitId":"*",
        "classId":"*"
    }
}

response = requests.post(url, headers=headers, json=data)

print("Status Code", response.status_code)
print("JSON Response ", response.json())


path = 'output.json'
with open(path, 'w+', encoding='UTF-8') as f:
    f.write(str(response.json()["d"]))