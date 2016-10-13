<!-- ============================================================ -->
        <!-- START: v18_head -->

        <link rel="icon" href="//www.ibm.com/favicon.ico">

        <meta name="robots" content="index,follow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="geo.country" content="<?php
        $temp = strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
        echo ($temp == '' ? "US" : $temp);
        ?>" />
        <meta name="dcterms.date" content="<?php echo the_time('Y-m-d'); ?>" />
        <meta name="dcterms.rights" content="© Copyright IBM Corp. 2016" />
        <meta name="description" content="<?php echo get_option('meta_page_description'); ?>">


        <?php
        $themeDetails = wp_get_theme();
        $post = get_post_type();
        $isHome = is_home();
        $pageTemplate = get_page_template();
        $templateType = substr($pageTemplate, strrpos($pageTemplate, "/") + 1);
        $specialPages = array("about","archive","categories","contributors");
        if($post == "post" && !$isHome && !in_array("page-".$templateType.".php", $specialPages) && !is_author() && !is_archive() && !is_category() && !is_tag()){
            $type = "CT915";
        }
        else{
            $type = "CT904";
        }

        ?>

        <script>
            digitalData = {
                page: {
                    category: {
                        primaryCategory: '<?php echo get_option('meta_page_primarycategory'); ?>'
                    },
                    pageInfo: {
                        effectiveDate: '<?php echo the_time('Y-m-d'); ?>',
                        expiryDate: '<?php echo date("Y-m-d",((get_post_time('U', true))+31536000*5));?>',
                        language: '<?php
                        $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-"))) . "-" . strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                        echo ($temp == '-' ? "en-US" : $temp);
                        ?>',
                        publishDate: '<?php echo the_time('Y-m-d'); ?>',
                        publisher: 'IBM Corporation',
                        version: 'v18',
                        ibm: {
                            contentDelivery: 'ibm.com/blogs',
                            contentProducer: '<?php echo $themeDetails->Name . " " . $themeDetails->Version; ?>',
                            country: '<?php
                            $temp = strtoupper(substr(get_option('meta_country'), strpos(get_option('meta_country'), "-") + 1));
                            echo ($temp == '' ? "US" : $temp);
                            ?>',
                            ibmDynamicCm: false,
                            industry: 'ZZ',
                            owner: '<?php echo get_option('meta_page_owner'); ?>',
                            siteID: '<?php echo get_option('meta_page_siteid'); ?>',
                            subject: 'IBM000',
                            type: '<?php echo $type; ?>',
                            GBTtags: {
                                gbt10_IBM_BU: '<?php echo get_option('meta_page_gbt10_IBM_BU'); ?>',
                                gbt17_Product_Segment: '<?php echo get_option('meta_page_gbt17_Product_Segment'); ?>',
                                gbt20_Primary_Brand: '<?php echo get_option('meta_page_gbt20_Primary_Brand'); ?>',
                                gbt30_Product_Family: '<?php echo get_option('meta_page_gbt30_Product_Family'); ?>'
                            }
                            }
                        }
                    }
                };
        </script>

        <script src="//1.www.s81c.com/common/stats/ida_stats.js"></script>

        <!-- IBM: BASE -->
        <link href="//1.www.s81c.com/common/v18/css/www.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/www.js"></script>

        <!-- IBM: FORMS -->
        <link href="//1.www.s81c.com/common/v18/css/forms.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/forms.js"></script>

        <!-- IBM: TABLES -->
        <link href="//1.www.s81c.com/common/v18/css/tables.css" rel="stylesheet" />
        <script src="//1.www.s81c.com/common/v18/js/tables.js"></script>

        <!-- IBM: METRICS -->
        <script src="//www.ibm.com/common/stats/ida_production.js" type="text/javascript">//</script>

        <!-- IBM: METRICS -->
        <script type="text/javascript" src="//www.ibm.com/software/info/js/tactic.js"></script>
        <script type="text/javascript" src="//www.ibm.com/software/info/js/tacticbindlinks.js"></script>


        <script src='//1.www.s81c.com/common/v18/js/masonry.js'></script>



       <?php
       if(get_option('v18_optional_widget_syntaxHighlighter') == "on")
       {
        ?> <!-- IBM: SYNTAX HIGHLIGHTER -->
        <link href="//1.www.s81c.com/common/v18/css/syntaxhighlighter.css" rel="stylesheet">
        <script src="//1.www.s81c.com/common/v18/js/syntaxhighlighter.js"></script>
        <?php
       }
       ?>

       <?php
       if(get_option('v18_optional_widget_dynamicTabs') == "on")
       {
        ?> <!-- IBM: DYNTABS -->
        <script src="//1.www.s81c.com/common/v18/js/dyntabs.js"></script>
        <?php
       }
       ?>

       <?php
       if(get_option('v18_optional_widget_mustache') == "on")
       {
        ?> <!-- IBM: MUSTACHE -->
        <script src="//1.www.s81c.com/common/v18/js/mustache.js"></script>
        <?php
       }
       ?>

        <script>
        <!--show alternate footer-->

        IBMCore.common.util.config.set({
            footer: {
              type: "alternate",
              socialLinks: { enabled:false }
            }
        });

        </script>


        <!-- END: v18_head -->
        <!-- ============================================================ -->
