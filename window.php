<?php
echo file_get_contents($_GET['url']);

// extracting id of the NPC
$npcId = str_replace("http://www.wowhead.com/npc=", "", $_GET['url']);
$npcId = str_replace("#starts", "", $npcId);

?>
<style>* { display: none; }</style>
<p id="text"></p>

<script>
  // passing the NPC ID from PHP to javascript
  var npcId = '<?= $npcId ?>';

  window.onload = function() {
    // Remove all useless tabs
    for (var i = 0; i < tabsRelated.tabs.length; i++)
    {
      if(tabsRelated.tabs[i].id != "starts" && tabsRelated.tabs[i].id != "ends" )
      {
        tabsRelated.tabs.splice(i, 1);
        i--;
      }
    }

    // initialize variables
    var a,ids = [],s;

    ids[0] = "";
    ids[1] = "";
    ids[2] = npcId;


    // Insert into element "#text" the HTML inside the tab "starts"
    document.getElementById("text").innerHTML = tabsRelated.tabs[0].owner.currentTabContents.innerHTML;

    // select all element "a" (<a>) and extract the link href, removing "/quest=" to href, to obtain only the id of the quest
    a = document.getElementById("text").getElementsByTagName("a");

    for (var i = 0; i < a.length; i++)
    {
      s = a[i].getAttribute("href");
      if (s != null)
      {
        if (s.indexOf("/quest=") > -1)
        {
          s = s.replace("http://www.wowhead.com/quest=", "");
          ids[0] += "\n("+npcId+", "+s+"),";
        }
      }
    }

    if (tabsRelated.tabs[1] != null)
    {

      // Insert into element "#text" the HTML inside the tab "ends"
      document.getElementById("text").innerHTML = tabsRelated.tabs[1].owner.currentTabContents.innerHTML;

      // select all element "a" (<a>) and extract the link href, removing "/quest=" to href, to obtain only the id of the quest
      a = document.getElementById("text").getElementsByTagName("a");
      for (var i = 0; i < a.length; i++)
      {
        s = a[i].getAttribute("href");
        if (s != null)
        {
          if (s.indexOf("/quest=") > -1)
          {
            s = s.replace("http://www.wowhead.com/quest=", "");
            ids[1] += "\n("+npcId+", "+s+"),";
          }
        }
      }
    }

    //document.write(ids);
    window.opener['win'] = ids;
    this.close();
  };
</script>
