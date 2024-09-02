# PPA-admin-client-engine

### Install

1. Copy the contents of the ***server/*** folder to your FTP anywhere - the admin panel will be there;

2. Copy the ***form/*** folder, which is located in the ***userform/*** folder, as well as it's contents to the FTP in the same directory where the page is located, on which the form will be displayed;

3. In the ***form/*** folder, find the ***Server_API_URL.txt*** file, open it in notepad or a text editor and specify in it the full address to the folder on your server where the admin panel itself is located. For example: ***http://domain.com/server/admin/***

4. Open your website HTML document containing the form using notepad or a text editor and add the following lines after the <body> tag:
```
<script type="text/javascript">var FormName = "ХХХ-ХХХ-ХХХ";</script>
<script type="text/javascript" src="form/js.js"></script>
<script type="text/javascript">start();</script>
```
- In the first line, instead of ХХХ-ХХХ-ХХХ, enter the name that the form is named in the document. For example, if <form name="fff"> - in this case, you need to replace ХХХ-ХХХ-ХХХ with fff

- If the form is not named <form>, name it at your discretion, for example <form name="fff">

5. Find the form submit button in the HTML document. It is usually located at the bottom near the closing form tag </form> and is written as follows: ```<input type="submit" ...```

- Change the button type to type="button"

- Add the line inside the button tag: ```onclick="sub()"```

You should get something like this: ```<input type="button" onclick="sub()"/>```

6. Save the document and make sure it has been updated on the server;

7. Open the admin panel in the browser - the URL to the FTP where you copied it and at the end add ***admin/*** press Enter and the "Administrator Interface" will open in front of you;

8. Log in with the login: admin and password: temp123. Attention! Immediately after logging in, change the login and password in the "Settings" section;

9. In the "Landings" section, add a new landing corresponding to the URL where you installed the form and describe its subject;

10. In the "Operators" section, add a new operator. In the "Available Landings" cell, click "+ add" and select from the list the landing to which this operator will have access;
In the "Statistics" cell, after the operators have processed several requests, you can click "Refresh" to find out the summary statistics of their work.
In the "Login" cell, you can click on the link and automatically log in to the "Operator Interface" under the login and password of the selected operator.

11. To access the "Operator Interface", open your URL in the browser again, only at the end, instead of /admin/, add /operator/. The operator logs in using the logins and passwords specified in the "Administrator Interface".

12. In the "Settings" section, enter the password for accessing the XML generator, which is specified in the campaign settings. By default, 12345 - replace it.

Enjoy your work!

(c) digg 2011

--

Features:

Each time a remote form is checked for correctness of fields filling, the program downloads a file from your server containing rules for checking ../server/form/form_items.txt , which can be changed in the "Settings" section;
