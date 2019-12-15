# Photo-Sharing Website
**by Rosty Hnatyshyn and Andy Yeung**

Written for Advanced Web Programming taught by Darren Provine, Fall Semester 2020, Rowan University.

Written with:
- JQuery 
- Bootstrap
- PHP

## File Structure
We split files into two categories - ones that interact directly with the database and ones that are meant for an end-user to interact with.

### Interactive pages:

**header.php** - This is not actually a page, but where the navbar and its interactive components are put.

**start.php** - This is where a user would enter the site and see the homepage.

**profile.php** - This is where a user's profile would be displayed, along with all the pictures they have uploaded. A user has the opportunity to edit their biography here and change their profile picture.

**photo.php** - This is where a photo on its own would be displayed, along with its number of likes and comments. Users that are logged in can add, edit and remove their own comments as well as like / unlike the photo. The photo's original uploader can delete comments if they feel they are offensive, as well as delete the photo.

**upload.php** - This is where a logged in user can upload a photo.

**gallery.php** - This is where a user or guest can view all of the photos that were uploaded to the website.

**password_reset.php** - This is where a user that has requested a password reset would be linked to in order to reset their password.

***

### Database pages:

**UserDBFuncs.php** - This file stores functions that connect to the user database that are used in other files.

**PhotoDBFuncs.php** - This file stores functions that connect to the user database that are used in other files.

**CommentDBFuncs.php** - This file stores functions that connect to the user database that are used in other files.

**checker.php** - This file validates usernames and emails to see if they exist in the database.

**comment.php** - This file provides an endpoint to add, edit or remove comments.

**Connect.php** - Connects to the database.

**delete.php** - This file provides an endpoint to delete profiles and photos.

**editprofile.php** - This file provides an endpoint to edit a user's biography or profile picture.

**login.php** - This file provides login functionality.

**logout.php** - This file provides logout functionality.

**register.php** - Provides registration functionality.

**search.php** - Returns a list of usernames and photo titles that match the query string.

**store_it.php** - Handles storing photos on the database.

**validEmail.php** - Validates emails.

**sendemail.php** - Provides functionality to send emails.
