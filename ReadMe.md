I hope this works as I think it will...

So to make the login work on your own venus account, you need to modify config.php with your personal info. In addition you need to create a table in mysql. This is subject to change until I get the offical table but the one that I currently use is a table called login with 3 columns - UserID, Username, Password. Create a new record with whatever you want and try to log in with said record to test if you want. 

--Login table

CREATE TABLE IF NOT EXISTS login (
    UserID INT AUTO_INCREMENT,
    Username VARCHAR(20),
    Password VARCHAR(20),
    PRIMARY KEY (UserID, Username)
);


--Creates an account called abc with password 1234

INSERT INTO login (Username, Password) 
VALUES ('abc', '1234');



If the html file looks weird (No images showing up etc) on your venus account, remember to chmodd 755 everything. You don't have to chmodd everything but I'm unsure which files are being affected.
