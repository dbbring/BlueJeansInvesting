====================== Blue Jeans Investing =============================

Basic layout of the blue jeans investing website is as follows:

templates/about.php - relies on the master template to form the about blue jeans investing page. 
templates/dashboard.php - relies on the master template to form the dashboard page that users are taken to after logging in.
templates/index.php - relies on the master template to form the main landing page.
templates/single.php - relies on the master template to form the main article layout page.
templtes/master.php - the main php file that declares the header, footer and navigation.

dashboard.php - controller for the dashboard page. 
index.php - controller for the main home page.
single.php - controller for the main article page.
about.php - controller for the about page.

-----MySQL Logins ----------

3 - masterTemplateDBFunctions.php
3 - dashboard.php -> Controller file
2 - index.php -> Controller file
1 - single.php -> Controller file

=======================================================
=					Notes							  =
=======================================================

Default setting for the user's tickers are null, and if
B.J.I. dashboard reads a null ticker, it automatically inserts
either the Dow, Nasdaq, or SP into its slot.

The user must first delete a ticker in order to add a new one.
If there are no empty slots, then the new ticker is inserted into
the first slot. Thus, if you keep adding tickers, then you are only
changing the first slot.

If a non-valid ticker is entered, the API calls return a blank widget.

If the user is logged in, then instead of a register widget, B.J.I 
displays a quotes widget.


