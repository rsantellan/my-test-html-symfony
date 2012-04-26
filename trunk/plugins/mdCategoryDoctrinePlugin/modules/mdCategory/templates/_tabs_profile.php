<style>
    ul.subsection_tabs {
    border-bottom:1px solid #CCCCCC;
    clear:both;
    height:20px;
    list-style:none outside none;
    margin:0 0 5px;
    padding:0;
    }
    ul.subsection_tabs li.tab {
        float:left;
        margin-right:7px;
        text-align:center;
        border:none;
        padding: 0px;
        width:80px;
    }

    ul.subsection_tabs li.tab a {
        background-color:#FFFFFF;
        color:#666666;
        display:block;
        height:20px;
        padding:0px;
        width:80px;
    }
    ul.subsection_tabs li.tab a:hover {
        color:#666666;
    }
    ul.subsection_tabs li.tab a.active {
        background-color:#DDDDDD;
    }
</style>


    <ul id="tabs_example_two" class="subsection_tabs">
        <li class="tab"><a href="#v1">Vehiculo 1</a></li>
        <li class="tab"><a href="#v2">Vehiculo 2</a></li>
        <li class="tab"><a href="#v3">Vehiculo 3</a></li>
        <li class="tab"><a href="#v4">Vehiculo 4</a></li>
    </ul>

    <div class="clear"></div>

    <div id="v1">
        <?php include_partial('homero/profile_form', array('form' => $forms[0], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[0])); ?>
    </div>
    <div id="v2">
        <?php include_partial('homero/profile_form', array('form' => $forms[1], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[1])); ?>
    </div>
    <div id="v3">
        <?php include_partial('homero/profile_form', array('form' => $forms[2], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[2])); ?>
    </div>
    <div id="v4">
        <?php include_partial('homero/profile_form', array('form' => $forms[3], 'mdProduct' => $mdProduct, 'mdProfileId' => $mdProfileIds[3])); ?>
    </div>


<script type="text/javascript">
 var tabs_example_two = new Control.Tabs('tabs_example_two',{
    beforeChange: function(old_container, new_container)
    {
    }
 });
</script>