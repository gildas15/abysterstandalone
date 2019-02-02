Abyster_standalone
==================

A Symfony project created on April 6, 2018, 9:42 am.
Project developt during my internship.

Project Title: A web application that will enable vendors to pursue and facilitate mobile payments on their websites.

Programming languages used: html, css, javascript, php
framework: symfony
library: jquery

## Brief description of the application

The web application work in two face, the dashboard face where the vendor will manage all transactions happening on various account and the API face.

## On the dashbord face: vendor should be able to manage all payment 
- By managing accounts(CRUD operation) from where payment will be done
- Managing aperators(CRUD operations) responsible to effectively perform the payment
- Managing all transactions that has been performed(read and update)


## The API face
on the API face we  have the following services:
- service that will process and register client request in the database while on vendor site
- service that will first receive payment information from a mobile application(this application is developt in java and it role is to intercept sms concerning client payment, extract neccessary information), treat those information and register client payment in the system.


## I have one copy of the application and it work locally, the DBMS used is MySql
The database of the project is inside the project root directory and it is name standaloneapp.sql.

##A user already exist in the system and the credentials to access the system are:
Username: Mba Gildas
Password: localhost1997





