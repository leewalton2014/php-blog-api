# PHP Blog API (Native PHP)
This repository contains an API to serve blog posts.

## Technologies Used
- OOPHP
- PDO
- Prepared statements
- MySQL

## Tables
PK = Primary Key
FK = Forign Key

### categories
id (PK)
name
created_at

### posts
id (PK)
category_id (FK)
title
body
author
created_at

## Config variables
Create env related variables from a xml file

### Example (config.xml)
```
<config>
    <dbname>myblog</dbname>
    <username>root</username>
    <password>password123</password>
</config>
```