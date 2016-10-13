# IBM THINK Blog Wordpress Theme
Built by VSA Partners

This is a first release of the THINK Blog theme. It was built specifically based on required functionality for the THINK Blog. There is quite a bit of room to evolve into a flexible and universal template, but for the time being that is not included. 

## Installing
You can install this theme by copying it into your Wordpress theme directory and activating it. Simple as that you're good to go.

##### Required Plug-Ins
Take note, the *Advanced Custom Fields Pro* plug-in is requied for this theme to work properly.

---
## For Editors
The theme is pretty much out-of-the-box Wordpress however there are a couple items you should be aware of.

1) If you would like to edit the header "Introduction" this can be found in WP-Admin at **Options > Header Intro**.
2) It is expected that posts are authored by someone, and posted by someone else. The author's headshot, name, and title are added through custom fields on the bottom of the post page. A post's "Posted By" attribution will be automatically added based on who created it in Wordpress.


---
## For Developers
All CSS and Javascript on the site is compiled into distribution files. Make sure you are running the `grunt watch` task in order for your changes to be compiled. 

### CSS
The theme uses LESS syntax, which you can find the source of at **assets/css/src/**. If you would like to add a new .less file, make sure to include it in the **__bootstrap.less** file.

### JavaScript
The theme uses normal JavaScript/jQuery, which you can find the source of at **assets/js/src/**. By default, any .js file located in the folder will be compiled into the site.js file during build.