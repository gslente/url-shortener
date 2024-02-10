# url-shortener
A simple URL Shortener made in compliance with application process

# Instructions for installation
1. Clone the repo to your local environment
2. Run 'composer install' to install all necessary packages
3. Set up the site as normal
4. Import the exported config file
   - You will need to change site's UUID to import config file
   - run the command 'drush config-set "system.site" uuid c4168954-1f7a-4876-bad2-6c9703c83874'
   - you may also need to run the command 'drush -y entity:delete shortcut_set'
5. Using the devel generate module, generate a sizable amount of Article content, make sure that field_article_link field is populated
6. Check the links at Article Links View ( /articles )
7. Click the short links to check if redirecting correctly