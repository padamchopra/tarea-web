const express = require('express');
const app = express();
const securePin = require('secure-pin');
const path = require('path')
const url = require('url');
const nodemailer = require('nodemailer');    


const bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({extended: false}));
app.use(bodyParser.json());
app.use((req, res, next) => {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept, Authorization"
    );
    if( req.method === 'OPTIONS'){
        res.header('Access-Control-Allow-Methods', 'PUT, POST, PATCH, DELETE, GET');
        return res.status(200).json({});
    }
    next();
});

app.use('/:assignee/to/guest', (req, res, next) => {
    const randomPin = securePin.generatePinSync(4);
    res.status(200).redirect('https://tarea-webapp.herokuapp.com/guest.php?assignee=' + req.params.assignee + '&pin=' + randomPin);
})

app.use('/:assignee/to/:assigned',(req, res, next) => {
    res.status(200).redirect('https://tarea-webapp.herokuapp.com/index.php?assignee=' + req.params.assignee + '&assignedto=' + req.params.assigned);
});

app.use('/addnewtask', (req, res, next) => {
    res.status(200).json({
        message: 'will add new task'
    })
})

app.use('/email/:emailaddress/:id', (req, res, next) => {
    var transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
          user: 'practikalityapps@gmail.com',
          pass: 'machinelearning'
        }
    });
    const emailTo = req.params.emailaddress;
    var mailOptions = {
        from: "practikalityapps@gmail.com",
        to: emailTo,
        subject: "New task added on Tarea",
        html: "You can view your task <a href='https://tarea-webapp.herokuapp.com/viewtask.php?id=" + req.params.id + "&mymail=" + emailTo + "'>HERE</a>!"
    };
    transporter.sendMail(mailOptions, function(error, info){
        if (error) {
            transporter.sendMail(mailOptions, function(error, info){
                if (error) {
                    transporter.sendMail(mailOptions, function(error, info){
                        if (error) {
                            transporter.sendMail(mailOptions, function(error, info){
                                if (error) {
                                    transporter.sendMail(mailOptions, function(error, info){
                                        if (error) {
                                          res.status(500).json({
                                              message: error
                                          })
                                        } else {
                                          res.status(200).json({
                                              message: 'Email sent!'
                                          })
                                        }
                                      });
                                } else {
                                  res.status(200).json({
                                      message: 'Email sent!'
                                  })
                                }
                              });
                        } else {
                          res.status(200).json({
                              message: 'Email sent!'
                          })
                        }
                      });
                } else {
                  res.status(200).json({
                      message: 'Email sent!'
                  })
                }
              });
        } else {
          res.status(200).json({
              message: 'Email sent!'
          })
        }
      });
})

app.use('/guestemail/:emailaddress/:id/:pin', (req, res, next) => {
    var transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
          user: 'practikalityapps@gmail.com',
          pass: 'machinelearning'
        }
    });
    var mailOptions = {
        from: "practikalityapps@gmail.com",
        to: req.params.emailaddress,
        subject: "Someone has a task for you.",
        html: "You can view your task at <a href='https://tarea-webapp.herokuapp.com/viewtaskforguest.php?id=" + req.params.id + "'>Here</a>!<br> Pin to view task is: " + req.params.pin
    };
    transporter.sendMail(mailOptions, function(error, info){
        if (error) {
          res.status(500).json({
              message: error
          })
        } else {
          res.status(200).json({
              message: 'Email sent!'
          })
        }
      });
})

app.use('/', (req, res, next) => {
    res.status(404).json({
        message: 'Try going to https://tarea-api.herokuapp.com/assignee/to/assignedto'
    })
})

app.use((error, req, res, next) => {
    res.status(error.status || 500);
    res.json({
        error: {
            message: error.message
        }
    });
})

module.exports = app;