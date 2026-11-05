// file encoding: UTF-8
// © 2010 airmedia.pl

function $(i){return document.getElementById(i);}
function addclass(el, na) { el.className+=' '+na; }
function remclass(el, na) { var re=new RegExp('( ?'+na+')','g'); el.className=el.className.replace(re,''); }
function isDefined(variable){ return eval('(typeof('+variable+') != "undefined");'); }

function closeModPanels(hiddenFrame)
{
 var panels=$('rightpanel').getElementsByTagName('DIV');
 for(var i=0;i<panels.length;i++)
  if(panels[i].className=='printmod') panels[i].style.display='';
 if(hiddenFrame === undefined) $('prev').style.display='';
 return true;
}

function openModPanel(panelid)
{
 closeModPanels(true);
 if($(panelid))
 {
  $('prev').style.display='none';
  $(panelid).style.display='block';
  if(panelid=='mod_mkdir') $('ndirnameid').focus();
  return true;
 }
 return false;
}

function selectBoxes(what, boxes)
{
 var inp = document.getElementsByTagName("INPUT");
 for(var i=0; i<inp.length; i++)
 {
  if(inp[i].name.indexOf(boxes) != -1)
   if(inp[i].getAttribute('type') == 'checkbox')
   {
	if(what == 1) inp[i].checked = false;
	if(what == 2) inp[i].checked = !inp[i].checked;
	if(what == 3) inp[i].checked = true;
   }
 }
 return true;
}

function doDelete(nmsg)
{
 var mfr=$('afmf');
 var found=false;
 var inp=mfr.getElementsByTagName("INPUT");
 for(var i=0;i<inp.length;i++)
  if(inp[i].getAttribute('type')=='checkbox' && inp[i].name.indexOf('zaz')!=-1 && inp[i].checked)
  {
   found=true;
   break;
  }
 if(!found) alert(nmsg);
 if(found && confirm($('js_msg_delete').value))
 {
  var ait=document.createElement('INPUT');
  ait.setAttribute('type', 'hidden');
  ait.setAttribute('name', 'action-delete');
  ait.value='foobar';
  mfr.appendChild(ait);
  mfr.submit();
  return true;
 }
 return false;
}
