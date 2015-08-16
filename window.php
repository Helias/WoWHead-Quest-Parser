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

    /*
    // Remove all useless tabs
    for (var i = 0; i < tabsRelated.tabs.length; i++)
    {
      if(tabsRelated.tabs[i].id != "starts" && tabsRelated.tabs[i].id != "ends" )
      {
        tabsRelated.tabs.splice(i, 1);
      }
    }
    */

    // initialize variables
    var a,ids = [],s, starts = false, ends = false;

    ids[0] = "";
    ids[1] = "";
    ids[2] = npcId;


    // Insert into element "#text" the HTML inside the tab "starts"
    for (var i = 0; i < tabsRelated.tabs.length; i++)
    {
      if (tabsRelated.tabs[i].id == "starts")
      {
        document.getElementById("text").innerHTML = tabsRelated.tabs[i].owner.currentTabContents.innerHTML;
        starts = true;
        break;
      }
    }

    if (starts)
    {
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
    }
    else
      ids[0] = "empty";

    // click to "ends" tab, to load all the quests ends
    var a = document.getElementsByTagName("a");
    for (var i = 0; i < a.length; i++)
    {
      if(a[i].getAttribute("href") == "#ends")
      {
        a[i].click();
        break;
      }
    }

    // Insert into element "#text" the HTML inside the tab "ends"
    for (var i = 0; i < tabsRelated.tabs.length; i++)
    {
      if (tabsRelated.tabs[i].id == "ends")
      {
        document.getElementById("text").innerHTML = tabsRelated.tabs[i].owner.currentTabContents.innerHTML;
        ends = true;
        break;
      }
    }

    if (ends)
    {
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
    else
      ids[1] = "empty";

    ids[3] = starts;
    ids[4] = ends;

    //document.write(ids);
    window.opener['win'] = ids;
    this.close();
  };
</script>
