Install Instruction

New Installation for Self Registration Module

1) Upload this module up to your server 
2) Go to /admin/build/modules/list
3) Enable User Registration
4) Now the Self Registration page will be show on this page /self/register


NOTE: This is a brand new module, so the .install file will install three tables into your database. 
However, if for some reason you already have this module enabled before, then you could change the install
file to use update hook to update the table. The alternative way is to avoid using update hook is as follow:

1) disable the User Registration page
2) Navigate to /admin/build/modules/uninstall and uninstall User Registration page, this will remove the old table(s).
3) Log into your DB and delete "covidien_user_registration" module in "system" table. After that you could enable the 
   module and the installation will install the tables for you.


TODO:

This module is not complete yet, it still need more development and link features together. Also, there is no security check
yet since it is still in development. Therefore, please do not test on the Permission and Security level at this point.
Require more clean up after all functions linked together.



GATEWAY-2279
	
[3.0 Sprint B-self-reg] 'Class of Trade' not reset after click 'Reset All Values' button
GATEWAY-2278
	
[3.0 Sprint B-self-reg] Date Picker Control not pop up when select 'Class of Trade' other than 'Ventilation'
GATEWAY-2277
	
[3.0 Sprint B-self-reg] 'Training Date' can select a date later than today and submit
GATEWAY-2276
	
[3.0 Sprint B-self-reg] Characters other than the number can be entered in 'Phone' number field and submit
GATEWAY-2275
	
[3.0 Sprint B-self-reg] Repeated language in 'Language' list
GATEWAY-2274
	
[3.0 Sprint B-self-reg] Layout of attach Certificate File is out of range
GATEWAY-2273
	
[3.0 Sprint B-self-reg] Check-box of 'I am Covidien Employee' not work
GATEWAY-2272
	
[3.0 Sprint B-self-reg] No hyperlink on the GDMP login page to launch Registration form
GATEWAY-2271
	
[3.0 Sprint B-self-reg] No 'Device Access' option in user self registration form
GATEWAY-2268
	
[3.0 Sprint B-self-reg] Customer Name and Customer Account not associate with each other
GATEWAY-2267
	
[3.0 Sprint B-self-reg] Default Role of Covidien user is not clear in SRD/User Story
GATEWAY-2266
	
[3.0 Sprint B-self-reg] Approving Manager list got from FTP is not consistent with the records in database
GATEWAY-2263
	
[3.0 Sprint B-self reg] Drop down list of 'Role' is Blank when first launch Registration Form
GATEWAY-2262
	
[3.0 Sprint B-self reg] 'Approving Manager' list in Registration Form has no value for user to select
GATEWAY-2261
	
[3.0 Sprint B-self reg] User can register with the same email address twice or more times
