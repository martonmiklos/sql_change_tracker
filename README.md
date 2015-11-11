# SQL change tracker
SQL change tracker

Have you ever got tried of managing your SQL schema changes and rolling out them to the targets?
I did got many times so I have created this tool to make life easier. 

It works in the follwing manner:

- There is a small CRUD webapplication baked in CakePHP.
- You can define application (whatever can be an application which is using a database)
- You can define as many systems as you need for an application (deployed instances of the applications)
- You can add your SQL changes to applications
- You can keep track your unrolled/rolled out changes for each system induvidually

The Greasemonkey script in the gs_script folder will inject a small piece of Javascript code to your adminer page which will add a "Save to SQL change tracker" link to your SQL query result view or after-alter-view. By clicking that link your query will be automatically added to the SQL change tracker through a REST API. 
