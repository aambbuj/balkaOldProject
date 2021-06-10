var express = require('express')
var app = express()
var passport = require('passport')
var session = require('express-session')
var bodyParser = require('body-parser')
var path = require('path');
require('dotenv').config()

//Body Parser
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());


app.get('/', (req, res) => {
    res.status(200).send({ message: "Hello!", });
});

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');



//Models
var models = require("./models");

//Routes

app.use('/project', require('./routes/project'));



//Sync Database
models.sequelize.sync().then(function () {
    console.log('Nice! Database looks fine')
}).catch(function (err) {
    console.log(err, "Something went wrong with the Database Update!")
});

//Listening APP at port 5000

app.listen(process.env.PORT, function (err) {
    if (!err)
        console.log("Site is live");
    else console.log(err)
});