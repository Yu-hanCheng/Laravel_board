# Download
* `git clone -b compete https://github.com/Yu-hanCheng/Laravel_board.git`
# Settings
* CREATE database
* Edit .env.example to .env, and set DB connection
# Steps
1. `composer install` 
2. `php artisan migrate`
3. `php artisan key:generate`
4. `php artisan serve`


# 功能
- [ ] 會員登入系統 (registe / login / logout)，發表文章、回覆留言、按讚都需要登入後才可使用，未登入者，只可觀看文章及觀看留言(也不可按讚)
- [x] 留言板可以發表文章，需記錄 發表時間、發表人、留言內容、顯示 按讚人數
- [x] 可以對文章 按讚、收回讚
- [x] 點選 按讚人數 可觀看所有有按過讚的人
- [x] 可以對文章做回覆，需記錄回覆時間、回覆人、回覆內容
- [x] 可以對文章的回覆做回覆，需記錄回覆時間、回覆人、回覆內容
- [x] 所有的東西都要依時間排序，最新的留言在 最上面

加分：
- [x] 把 Web 端、後端的 code 都部署到同一台機器上
- [x] 使用任一個 ci/cd 工具，讓 Web 端、後端任一開發者 push 後可以自動佈署
- [x] 文章、留言時間顯示
    * 距離現在，小於一個小時內，顯示幾分鐘前
    * 距離現在，大於一個小時但小於一天內，顯示幾小時前
    * 距離現在，大於一天，顯示幾月幾號
## 進度

##### Android:
![](https://i.imgur.com/s9PlOoc.jpg =250x)

##### Web:
* 週三：
    * 切版完成+login API串起來 
* 週四：
    * 顯示發文 回覆 人名
* 週五：
    * 顯示時間
    * 按讚數
    * 流言數

##### 後端：
* 週三：
    * 功能 api OK 
* 週四：
    * 上 Cloud
    * 處理CORS
    * 處理HTTPS
* 週五：
    * Github Action (CICD)
    * 補 index API

## 合作問題
1. !!!後端改資料格式未更新文件也未通知!!! (QQ沙拉跪Orz)
2. 回傳格式盡量一致
3. 文件直接寫範例資料較好

## 連結
～請大家多多指教～
* [API](https://www.notion.so/API-39599b71188e4c058570544f6007818b)
* [Backend](https://github.com/Yu-hanCheng/Laravel_board/tree/compete)
* [Web](https://github.com/xxxxtim/challengeTest)
* [Android](https://github.com/zoeaeen13/FacebookMessageBoard)