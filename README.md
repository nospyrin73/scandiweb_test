# Scandiweb Test Project
Scandiweb junior position test project

## Build Instructions
Install server-side dependencies:
```
/$ composer install
```

Enable PSR-4 compliant autoloading
```
/$ composer dump-autoload
```

Install client-side dependencies:
```
/$ cd client/ && npm install
```

Build production ready react app:
```
/client$ npm run build
```
Run the Docker containers:
```bash
/$ docker-compose up -d --build
```
Configure MySQL database:
```
/$ docker exec -it mysql_scandiweb sh
```
```
# mysql -u root -p
```
(you'll be prompted to enter the root password, `MYSQL_ROOT_PASSWORD`, which you can find in the `docker-compose.yml` file)

Create `scandiweb` database:
```
mysql> CREATE IF NOT EXISTS scandiweb;
```
The server should now be running locally on port `8080`. However, for development purposes you may choose to build the client-side automatically:
```
/client$ npm start
```
This will launch the react app on port `3000` and proxy any relative requests to the server running on port `8080`.
# Website

http://nospyrin.mywebcommunity.org

# Auto QA

![AutoQA](https://i.imgur.com/4XmTTUM.png)

As you can see from the live version, the app is fully functional. Yet the "Check all the Products checkboxes and delete products" test still fails. I believe there are two causes for this:
1) The checkbox elements are being manipulated programmatically in the test. I use React to manage the state of my app which makes this problematic because React's event handlers don't fire when the DOM is manipulated directly. I added a fix in commit [3e43d43](https://github.com/nospyrin73/scandiweb_test/commit/3e43d43119a36fcc4dd941246f41f5551f697d2b)

    But the test continues to fail so:

2. My app loads products data separately from the initial page. The testing utility being used, Codecept, seems to run tests on page load and doesn't wait for subsequent requests to finish. ([source](https://codecept.io/acceptance/#waiting)) I believe this to be the case because I tried to replicate the test code locally in my browser as such:
    ```js
    checkboxes = document.getElementsByClassName('delete-checkbox');

    for (let i = 0; i < checkboxes.length; i++){
        checkboxes[i].checked = true;
    }

    document.getElementById('delete-product-btn').click();
    ```
    which runs as expected. Which leads me to believe the test runs and fails before the app has the chance to load the products list. Fixing this would require me to rewrite a good chunk of my code so I refrained 😅
