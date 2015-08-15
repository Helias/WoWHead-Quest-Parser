<?php
function getHTML($url, $timeout)
{
  $ch = curl_init($url); // initialize curl with given url
  curl_setopt($ch, CURLOPT_USERAGENT, "TrinityCore"); // set  useragent
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
  curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
  return @curl_exec($ch);
}

//echo getHTML("http://www.wowhead.com/npc=28701/#starts", 10);
//echo file_get_contents("http://www.wowhead.com/npc=28701/#starts");

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
