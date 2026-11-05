window.onerror = function(e) { setcursor(); if( !window.hideerror ) { e = typeof e==='object'? e : window.event || {}; var a, i, s=[]; if( typeof e==='string' ) { s[s.length] = e; } else { for( i in e ) { a = e[i]; i = i.replace( /^error/g, '' ); if( a!==null && a!=='' && ( a!==0 || i!=='keyCode') && !( /^(behavior|bound|content|type|Url)/.test( i ) ) ) { s[s.length] = i + '\t' + ( i.length>9 ? '' : '\t' ) + a + ( i==='Message' ? '\n' : '' ); } } } if( window.confirm( 'Sorry, a Javascript error:\n\n' + s.sort().join( '\n' ) + '\n\nCancel to continue reporting.' ) ) { window.hideerror = true; window.status = 'To resume:    javascript: hideerror = 0    (in the addressbar).'; window.setTimeout( 'window.status = \'\';', 5000 ); } } return true; };

var loops = [
  'bewoners', 'boogie', 'come', 'clock', 'complainte', 'dance', 'dancing', 'dani', 'dreams', 'drive', 'skunk', 'walk', 'five',
  'freedom', 'grease', 'gunn', 'lola', 'money', 'moonlight', 'mysterious', 'nights', 'vanavond', 'paranoid', 'religion', 'personal',
  'californication', 'pavane', 'rain', 'relax', 'respect', 'respect', 'rose', 'rumours', 'shadows', 'smoke', 'smoor', 'up', 'whatever' ],
 gid = document.getElementById ? function( o ) { return window.document.getElementById( o ) || null; } :
  ( document.all ? function( o ) { return document.all( o ) || null; } : null ),
 rex = /\bexpanded\b/, Tm, U, X, Y;

if( self!==parent ) {
 try{ if( parent.raise ) { var d = self.document; d.onmousedown = d.onmousemove = d.onmouseup = function( e ) { parent.raise( e || self.event, self.location.href ); }; } } catch(e) { self.alert( 'gotsha' ); }
} else if( !self.name.indexOf( '_pop' ) ) {
 document.onkeydown = function( e ) { e = e || window.event||{}; if( e.keyCode===27 ) { if( window.opener && !window.opener.closed ) { window.opener.focus(); } window.close(); } };
} else {
 document.onkeydown = function( e ) { e = e || window.event||{}; var o = gid( 'q' );
  if( (e.srcElement||e.target)!==o ) {
   if( e.keyCode===37 ) { resiq( o, o.offsetWidth - 4 + 1 ); }
   if( e.keyCode===39 ) { resiq( o, o.offsetWidth - 4 - 1 ); }
  }
 };
}

if( !window.XMLHttpRequest && window.ActiveXObject ) { window.XMLHttpRequest = function() { var a = [ 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP', 'Msxml2.XMLHTTP.3.0', 'Msxml2.XMLHTTP.4.0', 'Msxml2.XMLHTTP.5.0' ], i = a.length; while(i--) { try { return new ActiveXObject( a[i] ); } catch(e) {} } return null; }; }

X = window.XMLHttpRequest ? new XMLHttpRequest() : null;

function getX( s, c ) {
 if( X && ( s = trim( s ) ) ) {
  setcursor( 'wait' );
  var m, states = [ 'Uninitialized', 'Loading', 'Loaded', 'Interactive', 'Complete' ], t = '',
   url = c==='viewsource' ? s : '/code/got.php?g=' + escape( s ).replace( /\+/g, '%2b' ) + ( c ? ( '&c=' + c ) : '' ) + '&r=' + Math.random(), w;
  X.open( 'GET', url, true );
  X.onreadystatechange = function() {
   window.status = 'XMLHttp state: ' + X.readyState + '  ' + states[X.readyState];
   if( X.readyState===4 ) {
    setcursor();
    if( X.status===200 ) {
     t = X.responseText;
     if( c==='viewsource' ) {
      setsam( X.responseText, X.getAllResponseHeaders() );
     } else if( (m = t.match( /^([\s\S]*)\n(\w+:\/\/[\S]+)(\s*title:([\s\S]+))?$/ )) ) {
      if( window.confirm( m[1] + '\n\nSee:\t' + ( m[4] ? ( m[4] + '\nURL:\t' ) : '' ) + m[2] ) ) {
       if( (w=window.open( m[2], '_pop' ) )) { w.focus(); } else { window.location.href = m[2]; }
      }
     } else {
      window.alert( t || [c,s].join( '\n' ) );
     }
    } else {
     window.alert( 'Sorry, an XMLHttp error:\n\nCode:\t' + X.status + '\nMessage:\t' + X.statusText + '\nURL:\t' + s  );
    }
   }
   window.status = window.defaultStatus;
  };
  X.send( null ); return false;
 }
}

function loaded() {
 function m( href, title, key, click, bg, o, w, y ) {
  var l = a.cloneNode( true );
  l.href = href || ( '#' + title || '' );
  l.title = ( title ? ' ' + title + '. ' : '' ) +
   ( key ? '\u000d Alt+' + key.charAt().toUpperCase() + ' ' : '' );
  if( key ) { l.accessKey = key.charAt(); }
  if( click ) { l.onclick = click; } // addevent( 'click', click, l );
  if( bg ) { l.style.backgroundImage = 'url(' + bg + ')'; }
  if( w ) { l.style.width = w + 'px'; }
  if( y ) { l.style.height = y + 'px'; l.style.top = k + 'px'; }
  if( o ) { o.insertBefore( l, null ); }
  return l;
 }
 function mi( type, id, value, size, key, url ) {
  var l = b.cloneNode( true );
  l.type = type;
  l.id = l.name = id;
  l.value = value;
  if( size ) { l.size = size; }
  if( key ) { l.accessKey = key.charAt(); }
  g.insertBefore( l, null );
  return l;
 }
 var d = window.document,
  a = d.createElement( 'a' ),
  b = d.createElement( 'input' ),
  c, f, g, h, i, j, k,
  l = window.location, p = l.protocol + '//' + l.hostname;

 Y = d.getElementsByTagName( 'h1' ); if( Y ) { Y = Y[0]; }
 a.insertBefore( d.createTextNode( '\u00a0' ), null );
 a.className = 'h';

 h = d.getElementsByTagName( 'code' ); i = h.length;
 while(i--) { j = h[i];
  j.onmouseover = j.onmouseout = lime; j.ondblclick = samexe;
 }

 h = d.links; i = h.length;
 while(i--) { j = h[i]; k = j.href;
  if( ( k.indexOf( p ) || k.indexOf( 'redirect.php' )>0 ) && k.indexOf( 'javascript:' ) && j.onclick===null ) {
   j.onclick = pop; j.className += ' pop'; j.title += j.title ? j.title +'&#13; ' + j.href : j.href;
  }
 }

 i = decode( d.referrer ).match( /(q(\w{3,})?|p|w)=([^&]*)/ );
 i = i ? i[3].replace( /^define:/, '' ) : '';
 f = d.createElement( 'form' );
 g = d.createElement( 'div' );
 p = g.cloneNode( false );
 j = d.createElement( 'span' );
 m( '#up', 'Drag to resize', '',
  function() { return false; }, '', j, 18 ).hideFocus = true;
 try { j.firstChild.style.cursor = 'col-resize'; } catch( ee ) {}
 j.firstChild.onmousedown = function( e ) {e = e || window.event||{};
  var b = typeof e.clientY==='number', o = gid( 'q' ),
   dragw = o.offsetWidth + ( b ? e.clientX : e.x ) - 3;
  d.ondragstart = d.onselectstart = function() { return false; };
  d.onmousemove = function( e ) { e = e || window.event||{};
   resiq( o, dragw - ( b ? e.clientX : e.x ));
  };
  d.onmouseup = function() { d.ondragstart = d.onselectstart = d.onmousemove = d.onmouseup = null; };
 };
 g.insertBefore( j, null );
 j = mi( 'text', 'q', i, 30, 's' );
 j.onfocus = function() { this.select(); };
 j.onkeyup = j.onmouseup = j.onpaste = toa;
 i = l.pathname.replace( /^\/([^\/]+).*$/, '$1' );
 if( i ) { mi( 'hidden', 'qf', i ); }
 mi( 'submit', 'qs', 'Find', 0 );
 g.title = ' Search this site. \u000d Alt+S ';
 f.insertBefore( g, null );
 f.action = '/find'; f.method = 'get'; f.id = 'sf'; f.name = 'sf'; f.style.display='none';
 d.body.insertBefore( f, d.body.firstChild );
 addevent( 'resize', resized );
 addevent( 'scroll', resized );
 if( f.elements.q.value ) { toa(); }

 h = d.getElementsByTagName( 'h3' ); i = h.length;
 j = m( '#up', '', '', function() { window.scrollTo( 0, 0 ); return false; }, '', p );
 j.firstChild.nodeValue = gettext( Y );
 j.style.padding = '0';
 j.style.fontWeight = 'bold';
 p.style.width = '24px';
 p.style.overflow = 'hidden';
 p.onmouseover = function() { this.style.width = '180px'; this.style.overflow = 'visible'; };
 p.onmouseout = function() { this.style.width = '24px'; this.style.overflow = 'hidden'; };
 f.insertBefore( p, null );
 while(i--) {
  g = h[i];
  if( p ) {
   k = trim( gettext( g ) );
   g.id = g.id || k.replace( /\W/g, '' ).toLowerCase();
   j = m( '#' + g.id, '', '', togh );
   j.firstChild.nodeValue = k;
   p.insertBefore( j, p.firstChild.nextSibling );
  }
  j = g; k = [ ' Collapse this:' ];
  while( ( j = j.nextSibling ) && ( b = ( j.tagName || 'text' ).toLowerCase() ) && [ 'noscript', 'h3' ].indexOf( b )<0 ) {
   if( [ 'h4', 'h5' ].indexOf( b )>-1 ) {
    if( !j.id ) { j.id = gettext( j ).replace( /\W/g, '' ).toLowerCase() || 'h4' + i; }
    f = m( '#' + j.id, '', '', null ); f.firstChild.nodeValue = gettext( j );
    if( !p.firstChild.nextSibling.nextSibling || p.firstChild.nextSibling.nextSibling.tagName.toLowerCase()!=='div') {
     c = d.createElement( 'div' ); c.className = 'sh';
    }
    c.insertBefore( f, null );
    p.insertBefore( c, p.firstChild.nextSibling.nextSibling );
   }
   if( [ '!', 'script' ].indexOf( b )<0 ) {
    k.push( b.replace( /^hr$/, 'ruler' ).replace( /^div$/, 'division' ).replace( /^h\d$/, 'heading' ).replace( /^p$/, 'paragraph' ).replace( /^[ou]l$/, 'list' ) );
   }
  }
  g.title = k.join( ' \n \u2219 ' );
  if( l.pathname!=='/find' ) {
   g.onclick = toggled;
   if( rex.test( g.className ) ) { toggled( g ); } else { g.className += ' expanded'; }
  }
 }
 var totim;
 var o = gid( 'up' ) || d.body.getElementsByTagName( 'h2' )[0] || Y;
 if( o ) {
  k = 2 + p.offsetHeight;
  if( l.pathname.indexOf( '/view' ) ) {
   j = m( '/view?' + escape( l.pathname ).substring( 1 ), 'View source', 'c', null, '/image/icon/css1.gif', o, 14, 16 );
   j.style.position = 'absolute';
   j.style.left = '0';
   j.style.top = '0';
   j.style.border = '0';
   j.style.backgroundColor = 'transparent';
   k+=14;
   j = m( '/juke?' + ran( loops ), 'Juke', 'j', pop, '/image/clip/note8up.gif', o, 12, 16 ); j.style.left = 20 + 'px';
  }
  pp = p.cloneNode( false ); p.parentNode.insertBefore( pp, null ); pp.style.padding = '0';
  j = m( '#', 'Highlight', 'h', function() {
   var a = getstyle( this, 'background-image' ),
    b = a.indexOf( '14off' )>-1,
    k = !b ? function( o ) { o.className += ' lo'; } : function( o ) { o.className = o.className.replace( / lo/, '' ); },
    h = document.getElementsByTagName( '*' ), i = h.length;
    while(i--) { if( /\bsam\b/.test( h[i].className ) || [ 'code', 'span' ].indexOf( h[i].tagName.toLowerCase() )>-1 ) { k( h[i] ); } }
    this.style.backgroundImage = b ? a.replace( /14off/, '14' ) : a.replace( /14/, '14off' );
    return false;
   }, '/image/icon/hi14.gif', pp, 14, 14 );
 }
 if( gid( 'toc' ) && (o = gid( 'toc' ) ) ) {
  o.style.left = Y.scrollWidth + 18 + 'px';
  Y.nextSibling.onmouseover = o.onmouseover = function() { if( totim ) { window.clearTimeout( totim ); totim = null; } gid( 'toc' ).style.top = '18px'; };
  Y.nextSibling.onmouseout = o.onmouseout = function() { totim = window.setTimeout( 'gid( \'toc\' ).style.top = \'-999px\';', 999 ); };
 }
 setcursor( 'wait' ); window.setTimeout( 'samtool(); setcursor();', 40 );
}

function addevent( e, f, o ) { o = o || window; if( o.addEventListener ) { o.addEventListener( e, f, true ); return true; } else if( o.attachEvent ) { return o.attachEvent( 'on' + e, f ); } }
function removeevent( e, f, o ) { o = o || window; if( o.removeEventListener ) { o.removeEventListener( e, f, true ); return true; } else if( o.detachEvent ) { return o.detachEvent( 'on' + e, f ); } }

function bykb( n, b ) { var a = [ 'bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ], i = 0, j = n; while( j>1024 && a[++i] ) { j /= 1024; } return ( ron( j, 3 ) + ' ' + a[i] + ( b && n>1024 ? ( ' (' + n + ' ' + a[0] + ')' ) : '' ) ); }

function decode( s ) { return ( typeof decodeURIComponent!=='undefined' ? decodeURIComponent( s ) : unescape( s ) ).replace( /\+/g, ' ' ); }

function getpos( o ) { var x = 0, y = 0; do { x += o.offsetLeft; y += o.offsetTop; } while( ( o = o.offsetParent ) ); return { x: x, y: y }; }

function getstyle( o, prop ) { if( o.currentStyle ) { prop = prop.replace( /-(\w)/, function( t, a ) { return a.toUpperCase(); } ); return o.currentStyle[prop]; } else if( window.getComputedStyle ) { o = window.getComputedStyle( o, '' ); return o.getPropertyValue( prop ); } }

function gettext( o ) { var s = '', j = o && o.firstChild, b; if( j && o.childNodes.length<150 ) { for( ; j!==null; j = j.nextSibling ) { if( j.nodeType===3 ) { s += j.nodeValue; } else if( j.nodeType===1 ) { b = ( /^(b|em|i|u|span|code)$/i.test( j.tagName ) ) ? '' : ' '; s += b + gettext( j ) + b; } } } return s.replace( /\s+/, ' ' ); }

function getwindow() { var d = document, v = window, w, h, l, t; if( typeof v.innerWidth==='number' ) { w = v.innerWidth; h = v.innerHeight; l = v.pageXOffset; t = v.pageYOffset; } else if( (v = d.documentElement) && typeof v.clientWidth==='number' && v.clientWidth!==0 || (v = d.body) ) { w = v.clientWidth; h = v.clientHeight; l = v.scrollLeft; t = v.scrollTop; } return { w: w, h: h, l: l, t: t }; }

function isie() { return '\v' == 'v'; }

function lime( e, o ) {
 e = e || window.event || {};
 o = o || this;
 var a = o.parentNode, b = o.childNodes.length-1,
  c = /over/i.test( e.type ) ? ( b ?  '#63cc63' : 'lime' ) : '',
  m = function( n ) {
   var d = a.getElementsByTagName( n ), i = d.length;
   while(i--) { if( d[i].className.replace( / lucid/, '' )===r && gettext( d[i] )===s ) { d[i].style.backgroundColor = c; ++t; } }
  }, r = o.className.replace( / lucid/, '' ), s = gettext( o ), t = 0;
 if( a ) {
  while( !( /^(body|div)$/i.test( a.tagName ) ) ) { a = a.parentNode; }
  m( 'code' );  m( 'span' );
  if( t && !b ) {
   t = t + 'x ' + s;
   a.title = a.title.indexOf('x ')<0 ? ( '\n' + t ) : a.title.replace( /\d+x .*$/, c ? ( '$1' + t ) : '' );
   if( ( t = trim( a.title ) ) ) { a.title = t; } else { a.title = ''; }
}}}

function live( vo ) { vo = gettext( vo || this ); try{ vo = eval( vo ); } catch(ve) { vo = ve.message; window.alert( 'Sorry, ' + vo.charAt().toLowerCase() + vo.substring( 1 ) + '.' ); } return false; }

function multi( n, s, m ) { n = parseInt( n, 10 ); return Math.round( n * 10 ) / 10 + ' ' + ( n>0&&n<2 ? s : ( m ? m : ( s + 's' ) ) ); }

function pop( o, e ) { o = o || this; e = e || window.event || {};
 var a = o.href.replace( /(\w+=)referr?er/, '$1' + window.location.href ),
  b = a.indexOf( '/juke?' )<0, t = b ? ( e.ctrlKey ? '_self' : '_pop' ) : '_juke', w, v = window.screen;
 if( a.indexOf( 'mailto:' )!==0  ) {
  if( (w = window.open( a, t, b ? '' : 'left=' + ( v.availWidth - 187 ) + ',top=' + ( v.availHeight - 223 ) + ',resizable,width=180,height=180' )) ) {
    w.focus(); return false;
  } else {
   o.target = t; return true;
 }
}}

function ran( a ) { return a && a.length ? a[ Math.floor( Math.random() * a.length ) ] : ( !isNaN( a ) ? Math.ceil( Math.random() * a ) : Math.random() ); }

function resized() {
 var o = gid( 'sf' ), p = gid( 'toc' ), a, b, i, j, v = getwindow(), u = 'url( /image/icon/arrow/smack-l.gif )';
 if( o ) {
  a = o.lastChild.childNodes; i = a.length;
  while( i-- && (j = a[i].href && a[i].href.substring( 1 )) && j!=='up' ) {
   b = gid( j )&&gid( j ).offsetTop > v.t;
   a[i].style.backgroundImage = b ? '' : u; u = b ? u : '';
  }
  o.style.top = v.t + 'px';
 }
 if( p ) {
  //p.style.top = 18 + 'px';
 }
}

function resiq( o, w ) { o.style.width = Math.min( getwindow().w - 100, Math.max( 20, w ) ) + 'px'; }

function restore( o ) { var i = o.options.length; while( i-- ) { if( o.options[i].defaultSelected ) { o.options[i].selected = true; break; } } }
function ron( n, s ) { s = Math.pow( 10, s || 2 ); return Math.round( n * s ) / s; }
function setcursor( how, o ) { how = how || ''; document.body.style.cursor = how; try{parent.document.body.style.cursor = how;}catch(e){} if( o ) { o.style.cursor = how; var a = o.getElementsByTagName( 'a' ), i = a.length; while(i--) { a[i].style.cursor = how; } } }
function sortcaseless( a, b ) { var i = (a+'').toLowerCase(), j = (b+'').toLowerCase(); return i===j ? 0 : ( i>j ? 1 : -1 ); }
function sortnumeric( a, b ) { var i = parseFloat( '0' + a ), j = parseFloat( '0' + b ); return i===j ? 0 : ( i>j ? 1 : -1 ); }
function togh() { var o = gid( this.hash.substring( 1 ) ); if( !rex.test( o.className ) ) { toggled( o ); } return true; }

// how must be false to collapse, null (absent) to toggle, otherwise will expand
function toggle( o, how ) { o = o || this; if( typeof o==='string' ) { o = gid( o ); } if( o ) { o.className = how || ( /\bhid\b/.test( o.className ) ) && how!==false ? o.className.replace( /(\s*)\bhid\b(\s*)/, '$1$2' ) : o.className + ' hid'; return false; } }

function toggled( o ) { o = o || this; if( typeof o==='string' ) { o = gid( o ); }
 var a = o.className, b = rex.test( a ), s = o.title, t = o.tagName, p = 'Expand', q = 'Collapse';
 if( a ) {
  o.className = b ? a.replace( rex, 'collapsed' ) : a.replace( /\bcollapsed\b/, 'expanded' );
  o.title = b ? s.replace( q, p ) : s.replace( p, q );
  while( ( o = o.nextSibling ) ) { if( o.tagName===t || o.id==='toc' ) { break; } toggle( o ); }
 }
 return false;
}

function toa() {
 var b, d = window.document,
  p = gid( 'sf' ).firstChild.firstChild, c = p.childNodes, f = c[0], i = c.length, j,
  s = gettext( f ) + ' ' + trim( d.forms.sf.elements.q.value );
 if( gettext( p )!==s ) {
  s = s.split( /[\s\.,;:!?\/\\()[\]\u0022]+/ ).unique();
  while(i) {
   if( ( j = c[i--] ) && s.indexOf( gettext( j ) )<0 ) { p.removeChild( j ); }
  }
  i = s.length;
  if( c.length<i+1 ) {
   while( c.length<i ) {
    b = f.cloneNode( true );
    b.onclick = b.onkeydown = tos;
    j = c.length%10;
    b.accessKey = j; b.title = ' Alt+' + j + ' ';
    b.style.background = '';
    b.style.cursor = 'help';
    p.insertBefore( b, null );
   }
   while(i--) { j = c[i].firstChild;
    if( j.nodeValue!==s[i] ) {
     j.nodeValue = s[i];
}}}}}

function tos( s ) { s = trim( s || gettext( this ) );
 if( !s ) { return false; }
 var b = 0, e, n = 0, r,
  alas = function() { window.alert( ran( [ 'Alas', 'Sorry' ] ) + ', there is no "'+s+'".' ); },
  good = function() { var o = r.parentElement();
   do { if( o.id==='sf' || ( /\bhid\b/.test( o.className || '' ) ) ) { return false; } }
    while( ( o = o.parentNode ) ); return true;
  },
  grab = function() { return r.findText( s, b?-1:1, b ); },
  look = function() { return grab() || ( n += r.moveStart( 'textedit', b?1:-1 ) ) && grab(); },
  step = function() { return b ? r.moveEnd( 'character', -1 ) : r.moveStart( 'character', 1 ); };
 if( window.find ) {
  if( !window.find( s ) ) { while( window.find( s, false, true ) ) { ++n; } } else { ++n; }
  if( !n ) { alas(); }
 } else if( window.document.selection ) {
  r = window.document.selection.createRange();
  e = window.event || {};
  if( !e.keyCode || e.keyCode>40 ) {
   if( e.ctrlKey ) { b = 1; }
   if( r.text && good() ) {
    step();
   } else {
    window.document.selection.empty();
    r = window.document.selection.createRange();
    r.moveToElementText( Y );
   }
   if( look() ) {
    if( !good() ) {
     while( step() && look() && Math.abs( n )<3 ) {
      if( good() ) { break; }
     }
    }  
    if( good() ) {
     r.select(); r.scrollIntoView();
     if( r.offsetTop<28 ) { window.scrollBy( 0, -28 ); }
    } else { alas(); }
   } else { alas(); }
  }
 }
 r.parentElement().focus();
 return false;
}

function samtool( how ) {
 function v( o ) {
  b = a.cloneNode( true );
  b.onclick = live;
  for( s = o.firstChild; s!==null; s = s.nextSibling ) {
   b.insertBefore( s.cloneNode( true ), null );
  }
  o.insertBefore( b, o.firstChild );
  while( b.nextSibling ) { o.removeChild( b.nextSibling ); }
 }
 var d = document, a = d.createElement( 'a' ), b, g,
  h = d.getElementsByTagName( 'div' ), i = h.length,
  j, k, l, m, n, o, p = d.createElement( 'ol' ),
  r = isie() ? /[ \f\t\v\u00a0\u2028\u2029]*(\r\n?)/g : /[ \f\t\v\u00a0\u2028\u2029]*(\r?\n)/g, s, t,
  u = d.title.replace( /^.*?(View:\s*(.*\/))?[^\/]*$/, '$2' ).replace(/^http:\/\/\w+\.\w+\//, '/view?' );
 a.href = '#live'; a.style.color = 'black';
 while(i--) { g = h[h.length-1-i];
 if( /\bsam\b/.test( g.className ) && ( j = g.firstChild ) ) {
  for( ; j!==null; j = j.nextSibling ) {
   if( /^(pre|textarea)$/i.test( j.tagName ) && ( l = trim( j.firstChild && j.firstChild.nodeValue || j.value ) || ( /\b(htm|php)\b/.test( g.className ) ) ) ) {
    s = j.className + ' ' + g.className;
    k = ( s + ' js' ).match( /\b(css|s?html?|js|phps?|txt|xml)\b/ )[1].toLowerCase();
    if( /\beva\b/.test( s ) ) {
     if( k==='css' ) {
      if( d.createStyleSheet ) {
       d.createStyleSheet( 'javascript:"' + l.replace( /"/g, '&quot;' ) + '"' );
      } else {
       b = d.createElement( 'link' ); b.rel = 'stylesheet';
       b.href = 'data:text/css,' + escape( l );
       d.getElementsByTagName( 'head' )[0].insertBefore( b, null );
      }
     } else {
      b = d.createElement( 'script' ); b.type = 'text/javascript';
      b.text = l.replace( /\r/g, '\n' ).replace( /(\n)?([^\n]*)\/\*\*\/(\n)?/g, '$3' );
      d.body.insertBefore( b, null );
     }
    }
    if( how || !( /\bnot\b/.test( s ) ) ) {
     if( l===true ) { o=j; } else {
      m = l.replace( /\/\*\*\//g, '' );
      o = p.cloneNode( true );
      o.innerHTML = '<li>' + (
       k==='php' ? m : ( k==='css' ? hilitecss(m) : ( k==='txt' ? hilitetxt(m) : ( k==='js' ? hilitejs(m) : hilitehtml(m) ) ) )
       ).replace( /\t/g, '         ' ).replace( r, '<\/li><li>' ).replace( /\s\s/g, '&nbsp;&nbsp;' ).replace( /(<li>)\s/g, '$1&nbsp;' ) + '<\/li>';//replace( /([\r\n])[ \f\t\v\u00a0\u2028\u2029]/g, '$1&nbsp;' ).
      if( /\bno\b/.test( s ) || o.childNodes.length===1 ) {
       o.className = 'no';
      }
      g.insertBefore( o, j );
      g.removeChild( j );
      j = o;
      if( m!==l ) {
       m = l.replace( /\r/g, ' \r' ).split( /\r/ ); n = m.length;
       while(n--) { if( /\/\*\*\//.test( m[n] ) ) { v( o.childNodes[n] ); } }
      }
     }
     m = o.getElementsByTagName( 'li' ); n = m.length;
     while(n--) { s = m[n]; s.onmouseover = function() { this.className = 'line'; }; s.onmouseout = function() { this.className = ''; }; }
     m = o.getElementsByTagName( 'span' ); n = m.length;
     if( k==='html' ) {
      while(n--) { s = m[n];
       if( s.className==='value' && (t = s.firstChild && s.firstChild.nodeValue) &&
         (l = m[n-1]) && l.className==='att' && l.firstChild && ( /^(action|code(base)?|href|src)*$/i.test( l.firstChild.nodeValue ) ) ) {
        b = a.cloneNode( true ); b.insertBefore( s.cloneNode( true ), null );
        l = !t.indexOf('http:') || !t.indexOf('javascript:') || !t.indexOf('mailto:') || !t.indexOf('#');
        b.href = l ? t : ( !t.indexOf('/') ? t : ( u + escape( t ) ) );
        b.style.color = l ? 'blue' : 'green';
        s.parentNode.insertBefore( b, s );
        s.parentNode.removeChild( s );
       }
      }
     } n = m.length;
     while(n--) { s = m[n]; s.onmouseover = s.onmouseout = lime; s.ondblclick = samexe; }
    }
  } }
 } } return false;
}

function samexe( e, o ) {
 e = e || window.event || {};
 o = o || e.target || e.srcElement;
 e.cancelBubble = true; if( e.stopPropagation ) { e.stopPropagation(); }
 var va = trim( o.firstChild.nodeValue ), vb = window[va], vc, vi, vn, vr = [''], vt,
  divider = '\n - - - - - - - -\n';
 if( va==='this' || o.className==='cssprop' ) { return getX( va, o.className ); }
 if( e.ctrlKey || (o.className==='value' || o.className==='cssval') ) {
  if( (vb = window.prompt( ( o.className==='value' ? 'HTML' : 'CSS' ) + ' value:', va )) ) { o.firstChild.nodeValue = vb; }
  return false;
 }
 if( !vb ) {
  try { vb = gid( va ) || eval( va ); }
  catch(E) {
   if( /^#?([0-9a-f]{6}|[0-9a-f]{3})$/i.test( va ) ) {
    if( window.confirm( va + ' looks like a color.\nTry it in our colour editor?' ) ) {
     vt = '/web/css/color.php?' + va;
     vi = window.open( vt, '_popcol', 'width=540,height=220,resizable' );
     if( vi ) { vi.focus(); } else { window.location.href = vt; }
    }
    return false;
   }
   return getX( va, o.className );
  }
 }
 vc = vb ? vb.toString() : 'Nada'; vt = typeof vb;
 if( vt==='function' ) {
  if( vc.indexOf( '[native code]' )>0 ) {
   return getX( va, o.className );
  } else {
   vc = vc.split(/\n/); vn = vc.length;
   vr[0] = 'Function "' + va + '" of ' + multi( vn, 'line' ) + divider;
   for( vi = 0; vi<vn; ) { vr[vr.length] = (vi+1) + ' :\t' + vc[vi++] + '\n'; }
  }
 } else if( vt==='object' ) {
  if( vb && vb.constructor && vb.constructor===Array ) { vn = vb.length;
   for( vi = 0; vi<vn; ) { vr[vi+1] = vi + ' :\t' + vb[vi++].toString() + '\n'; }
   vr[0] = 'Array "' + va + '" with ' + multi( vn, 'value' ) + divider;
  } else {
   for(vi in vb) { if( vb[vi]!==null && vb[vi]!=='' ) { vr[vr.length] = vi + '\t' + ( vi>9?'':'\t' ) + vb[vi] + '\n'; } }
   if( vr.length<2 ) { return getX( va, o.className );  }
   if( vb.tagName ) { vr.sort(); }
   vr[0] = 'Object "' + va + '" with ' + multi( vr.length-1, 'set property', 'set properties' ) + divider;
  }
 } else if( vt!=='undefined' ) {
  vn = typeof vb.length==='number' ? ' [' + vb.length + ']' : '';
  vr[0] = vt.charAt().toUpperCase() + vt.substring( 1 ).toLowerCase() + vn + divider + vc;
 } else {
  return getX( va, o.className );
 }
 if( (vr = trim( vr.join( '' ) || va )) ) { window.alert( vr ); return false; }
}

//---------------------------------------------proto

if( typeof Array.prototype.copy==='undefined' ) { Array.prototype.copy = function() { var a = [], i = this.length; while( i-- ) { a[i] = typeof this[i].copy!=='undefined' ? this[i].copy() : this[i]; } return a; }; }
Array.prototype.indexOf = function( n ) { for( var i=0; i<this.length; i++ ) { if( this[i]===n ) { return i; } } return -1; };
Array.prototype.unique = function( b ) { var a = [], i, l = this.length; for( i=0; i<l; i++ ) { if( a.indexOf(this[i], 0, b ) < 0 ) { a.push( this[i] ); } } return a; };
String.prototype.tohtml = function() { return this.replace( /&/g,'&amp;').replace( /</g, '&lt;' ).replace( />/g, '&gt;' ).replace( /"/g, '&quot;' ); };
function toli( s, b ) { s = s.tohtml().replace( /  /g, ' &nbsp;' ).replace( /\n /g, '\n&nbsp;' ).replace( /\n/g, '\n<\/li><li>' ); return '<li>' + ( b ? s.replace( /&lt;(\/)?span( class=["\w]+)?&gt;/g, '<$1span$2>' ) : s ) + '<\/li>'; }
function trim( s ) { return ( s || '' ).replace( /^\s*|\s*$/g, '' ); }

//---------------------------------------------hiliting

function hilite(t,ext) {
 if(ext=='css') { return hilitecss( t ); }
 else if(ext=='txt') { return hilitetxt( t ); }
 else if(ext=='html') { return hilitehtml( t ); }
 return hilitejs( t );
}

function hilitetxt( s ) {
 s = s.replace( /&(\w+);/g, 'XxX$1YyY' ).replace( /((\d*)[\w-]*)/g, function(t,a,b) {
  return ( b ? ( '<span class="num">'+b+'</span>' ) : '' ) + a ? ( '<span>'+a+'</span>' ) : '';
 } ).replace( /XxX(\w+)YyY/g, '&$1;' );
 return s;
}

function hilitecss( s ) {
 s = ( ' ' + s ).tohtml().replace( /([^{]+)(\s*\{\s*)([^\}]+?)(\s*\})/g, function( t, a, b, c, d ) {
  a = a.replace( /(\.([a-z][\w-]*)\b)/gi, '<"cssclass">$1<\/span>' );
  a = a.replace( /(:([a-z][\w-]*)\b)/gi, '<"csspseu">$1<\/span>' );
  a = a.replace( /(#([a-z][\w-]*)\b)/gi, '<"cssid">$1<\/span>' );
  a = a.replace( /([>\s,])(([a-z]\w*)\b)/gi, '$1<"cssselector">$2<\/span>' );
  return a.replace(/<"/g,'<span class="') + b + '<span class="cssrule">' + hilitecssrule( c ) + '<\/span>' + d;
 } );
 s = s.replace( /(\/\*[\w\W]*?\*\/)/g, '<span class="comment">$1<\/span>' );
 return s.substring( 1 );
}

function hilitecssrule( s ) {
  s = s.replace( /(([a-z-]+)(\s*:\s*)([^;]*)(;?))/gi, '<span class="cssprop">$2<\/span>$3<span class="cssval">$4<\/span>$5' );
  return s;
}

function hilitehtml( t ) {
 function vl( i ) {
  var v = s.substr( i, y - i );
  if( /^on\w+/i.test( AT ) ) { return i==6 ? hilitejs( v.replace(/\\"/g, '"' ) ).replace( /"/g, '\\"' ) : hilitejs( v.replace(/\\'/g, "'" ) ).replace( /'/g, "\\'" ); }
  return ( /^style/i.test( AT ) ) ? hilitecssrule( v ) : v;
 }
 var now = new Date(), dif, old;
 var a0 = 'QZ', a1 = [ '&', a0, '<', '>', '"' ], a2 = [ a0, '&amp;', '&lt;', '&gt;', '&quot;' ],
  s, n, x, y, NV = '', TK = '', lastTK = '', AT = '', IS = 0, bas, vat;
 while( t.indexOf( a0 ) + 1 ) { a0 += Math.round( Math.random() ) ? 'X' : a0; }
 n = a1.length;
 for( x = 0; x < n; x++ ) { while( t.indexOf( a1[x] ) + 1 ) { t = t.replace( a1[x], a2[x] ); } }
 n = t.length;
 for( x = 0; x < n; x++ ) {
  if( old===x ) {
    y = t.substr(0,x).split(/\r?\n|\r/).length;
    window.alert( 'Highlighting problem on line ' + y + ':\n\n' + t.substr(x-100,x+100).replace( /&quot;/g, '"' ).replace( /&gt;/g, '>' ).replace( /&lt;/g, '<' ).replace( /&amp;/g, '&' ) );
    NV += s; break;
  }
  s = t.substr( x ); old = x;
  dif = new Date() - now; window.status = 'Highlighted ' + Math.round(x / n * 100) + '%'; if(dif>70000) { NV += s; break; }
  if( (y = s.match(/^\s+/)) ) {
    NV += y[0]; x += y[0].length-1;
  }else if( TK ) {
    if( s.charAt()=='=' ) {
      NV += '='; IS = 1;
    }else if( (y=s.match(/^\s*\/?\s*&gt;/)) ) {
      NV += '<span class=tag>'+y[0]+'<\/span>'; x+=y[0].length-1; TK=''; IS=0;
    }else if( !IS ) {    //  atr
      AT = s.replace(/((http-|xml:)\w*)?\W[\w\W]*/i,'$1');
      NV += '<span class=att>'+AT+'<\/span>'; x += AT.length-1;
    }else { IS=0;    //  val
      if( s.charAt()==="'" ) { bas = 0;  //  'string'
       for( y = 1; ( bas%2 || s.charAt(y) != "'" ) && y < s.length - 1; y++ ) {
         bas = ( s.substr(y,2)==='\\\\' || s.substr(y,2)==='\\\'' ) ? bas+1 : 0;
       }
       NV += "'<span class=value>"+vl( 1 )+"<\/span>'"; x += y;
      } else if( s.substr(0,6)==="&quot;" ) { bas = 0;  //  "string"
        for( y = 1; ( bas%2 || s.substr(y,6) != "&quot;" ) && y < s.length - 1; y++ ) {
          bas = ( s.substr(y,2)==='\\\\' || s.substr(y,7)==='\\&quot;' ) ? bas+1 : 0;
        }
        NV += '&quot;<span class=value>'+vl(6)+'<\/span>&quot;'; x += y+5;
      } else{
        y=s.replace(/(&gt;|\s)[\w\W]*/,'');
        vat=(/^\w+=/.test(s.substr( 1 )))?'att':'value';  //  fix empty attributes - broken
        NV += '<span class='+vat+'>'+y+'<\/span>'; x += y.length-1;
      }
    }
  } else if( s.indexOf( '&lt;' ) ) {
    y = s.replace( /&lt;[\w\W]*/, '' );
    NV += y; x += y.length-1;
  } else if( (y=s.match(/^(&lt;!\s*\[\s*CDATA\s*\[)(\s*)([\w\W]*?)(\s*)((\/\/)?\]\]&gt;)/)) ) {
    if( !lastTK.indexOf( 'script' ) && y[3] ) {
     a0 = t.substr( 0, x ).replace( /(\r?\n|\r)/g, '$1xcx' ).split( /\r?\n|\r/ ).length + 1;
     a1 = a0 + y[3].replace( /(\r?\n|\r)/g, '$1xcx' ).split( /\r?\n|\r/ ).length;
     NV += '<span class=comment>' +
      y[1].replace( /CDATA/, '<a href="#CDATA" title=" Toggle lines ' + a0 + ' to ' + a1 + '. " onclick="return togli(this);">CDATA<\/a>' ) +
      '<\/span>' + y[2] + '<span class=comment>' + hilitejs( y[3] ).replace( /(\r\n?)/g, '<\/span>$1<span class=comment>' ) + '<\/span>' + y[4] + '<span class=comment>' + y[5] + '<\/span>';
    } else {
     NV += '<span class=comment>' + y[0].replace( /(\r?\n|\r)/g, '<\/span>$1<span class=comment>' ) + '<\/span>';
    }
    x += y[0].length - 1; IS = 0;
  } else if( (y = s.match(/^&lt;!--[\w\W]*?--&gt;/)) ) { y = y[0];
    NV += '<span class=comment>' + y.replace( /(\r\n?|\r) /g, '$1&nbsp;' ).replace( /(\r?\n|\r)/g, '<\/span>$1<span class=comment>' ) + '<\/span>'; x += y.length - 1; IS=0;
  } else if( (y = s.match(/^&lt;!DOCTYPE[\w\W]*?&gt;/)) ) { y = y[0];
    NV += '<span class=comment>' + y.replace( /(\r\n?|\r) /g, '$1&nbsp;' ).replace( /(\r\n?|\r)/g, '<\/span>$1<span class=comment>' ) + '<\/span>'; x += y.length-1; IS=0;
  } else if( (TK = s.replace( /(&lt;\/?\w+(\s*\/?\s*&gt;)?)[\w\W]*/, '$1' )) ) {    //  a tag!
    NV += '<span class=tag>' + TK.replace( /(\s+)&gt;/, '<\/span>$1<span class=tag>&gt;' ) + '<\/span>'; x += TK.length - 1;
    if( TK.substring( TK.length - 4 )==='&gt;' ) { TK = ''; if( !lastTK.indexOf( 'script' ) ) { /*alert( lastTK+'\n\n'+TK+'\n\n'+s );*/ } } else { lastTK = TK.substring(4).toLowerCase(); }
  } else {  //  it wasn't a tag after all - no spaces allowed here
    NV += '&lt;'; x += 3;
  }
 }
 window.status = 'Highlighted HTML in ' + dif / 1000 + ' sec.'; Tm = window.setTimeout( 'window.status=window.defaultStatus;', 5000 );
 return NV;
}

function togli( o ) {
 var li = o.parentNode.parentNode,
  b = li.nextSibling.style.left,
  m = o.title.match( /(\d+)/g ),
  n = ( +m[1] ) - ( +m[0] );
 while( n-- && li ) {
  li.nextSibling.style.position = b ? '' : 'absolute';
  li.nextSibling.style.left = b ? '' : '-9999px';
  li = li.nextSibling;
 }
 return false;
}

function hilitejs( t ) {
 function ar( s ) {
  var a = [ ':', '?', '!', '%', '*', '~', '^', '|', '||', '&amp;', '&amp;&amp;', '&lt;', '&lt;&lt;', '&lt;&lt;&lt;', '&gt;', '&gt;&gt;', '&gt;&gt;&gt;', '=', '==', '===', '!=', '!==', '-', '--', '+', '++', '&lt;=', '&gt;=', '-=', '+=', '*=', '/=' ], i = a.length;
  while( i-- ) { if( s.substr(0,a[i].length)===a[i] ) { return a[i]; } } return false;
 }
 var now = new Date(), dif, old,
  w1 = ' for if while switch with typeof void return function ',
  w2 = ' function var new else return do break continue case default in delete typeof ',
  w3 = ' null false true ',
  n, s, x, y, NV = '', TK, bas, a0 = 'Q';
 while( t.indexOf( a0 ) + 1 ) { a0 += Math.round( Math.random() ) ? 'X' : a0; }
 var a1 = ['&',a0,'<','>','"'], a2 = [a0,'&amp;','&lt;','&gt;','&quot;'];
 for( x = 0; x < a1.length; x++ ) { while( t.indexOf( a1[x] ) + 1 ) { t = t.replace( a1[x], a2[x] ); } }
 n = t.length;
 for( x = 0; x < n; x++ ) {
  if(old===x) { y=t.substr(0,x).split(/\n/).length; window.alert( 'Highlighting problem on line ' + y + ':\n\n' + t.split(/\n/)[y-1].replace(/&quot;/g,'"').replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&amp;/g,'&') ); NV+=s; break; }
  s = t.substr( x ); old = x;
  dif=new Date()-now; window.status='Highlighted ' + Math.round(x / n * 100) + '%';// if(dif>7000) { NV+=s; break; }
 // if(!confirm(x+'\n'+NV)) { NV+=s; break;}  //  safety net
  if( s.charAt().replace(/[\w\+\-\*\/%=&\!\|\^~\'\"\?:]/,'') ) { NV += s.charAt(); } else {
   if( !s.charAt().replace(/[a-zA-Z_]/,'') ) {  //  variable or function or keyword or true/false/null
    TK = s.replace(/\W[\w\W]*/,'');
    x += TK.length - 1;
    if( s.replace(/\w*\s*/,'').charAt()==='(' ) {  //  function/method or ...
     if( w1.indexOf(' '+TK+' ')>-1  ) {
      NV += '<span class=oper>'+TK+'<\/span>';
     } else { NV += '<span class=func>'+TK+'<\/span>';
    } } else {  //  variable or keyword or bool
     if( w2.indexOf(' '+TK+' ')>-1 ) {
      NV += '<span class=oper>'+TK+'<\/span>';
     } else { if( w3.indexOf(' '+TK+' ')>-1 ) {
       NV += '<span class=num>'+TK+'<\/span>';
      } else { NV += '<span class=var>'+TK+'<\/span>'; } } }
   } else { if( !s.charAt().replace(/[\d]/,'') ) {  //  numbers (+ & - signs are operators)
     NV += '<span class=num>'+s.replace(/[^0-9.xE][\w\W]*/,'')+'<\/span>';
     x += s.replace(/[^0-9.xE][\w\W]*/,'').length - 1;
    } else {  //  ops, comments, regex and strings
     if( s.substr(0,2)!=='/*' && s.substr(0,2)!=='//' ) {  //  ops,regex,',"
      if( s.charAt()==="'" ) { bas = 0;  //  'string'
       for( y = 1; ( bas%2 || s.charAt(y)!=="'" ) && y < s.length - 1; y++ ) {
        bas = ( s.substr(y,2)==='\\\\' || s.substr(y,2)==='\\\'' ) ? bas+1 : 0;
       }
       NV += "'<span class=string>"+s.substr(1,y-1)+"<\/span>'"; x += y;
      } else { if( s.substr(0,6)==="&quot;" ) { bas = 0;  //  "string"
        for( y = 1; ( bas%2 || s.substr(y,6)!=="&quot;" ) && y < s.length - 1; y++ ) {
          bas = ( s.substr(y,2)==='\\\\' || s.substr(y,7)==='\\&quot;' ) ? bas+1 : 0;
        }
        NV += '&quot;<span class=string>' + s.substr(6,y-6) + '<\/span>&quot;'; x += y+5;
       } else { if( (y=ar(s)) ) {  //  ops, regex
         NV += '<span class=oper>' + y + '<\/span>';
         x += y.length - 1;
        } else {  //  regex and /. divide preceeded by word or number or ) then whitespace
         for( y = -1; x + y!==0 && ( ' \t\r\n\f'.indexOf( s.charAt(x+y) )>-1 ); y-- ) { /*alert(x+'\t'+y+'\t'+s.charAt(x+y)+'\n\n'+s.substring(0,100)); */}
         if( !s.charAt( y ).replace(/[\)\w\]]/,'') ) { NV += '<span class=oper>/<\/span>';  //  divide  //  ? if inverted !
         } else { bas = 0;  //  regex
          for( y = 1; ( bas%2 || s.charAt(y) != '/' ) && y < s.length - 1; y++ ) {
           if( s.charAt(y)==='\\' && ( s.charAt(y+1)==='\\' || s.charAt(y+1)==='/' ) ) {
            bas++; } else { bas = 0; }
          }  //  got the regex, now catch the flags
          NV += '/<span class=reg>' + s.substr(1,y-1) + '<\/span>/'; x += y; y = x;
          if( 'gim'.indexOf( s.charAt( 1 ) )>-1 ) { x++; }
          if( 'gim'.indexOf( s.charAt( 1 ) )>-1 ) { x++; }
          if( 'gim'.indexOf( s.charAt( 1 ) )>-1 ) { x++; } if( x > y ) {
           NV += '<span class=reg>' + t.substr( y+1, x-y ) + '<\/span>'; } } } } }
     } else { if( s.substr(0,2)==='/*' ) {  //  block comments
       y=s.replace(/\*\/[\w\W]*/,''); NV += '<span class=comment>'+y+'*/<\/span>';
       x += y.length + 1;
      } else {  //  line comments
       y=s.replace(/[\n\r][\w\W]*/,''); NV += '<span class=comment>'+y+'<\/span>';
       x += y.length - 1; } } } } } }
 window.status = 'Highlighted Javascript in ' + dif / 1000 + ' sec.'; Tm = window.setTimeout( 'window.status = window.defaultStatus;', 5000 );
 return NV;
}

//---------------------------------------------cookies

function setcookie( name, value, expiry, path, domain ) {
 if( expiry ) {
  var now = new Date();
  now.setTime( now.getTime() + Math.round( 86400000 * expiry ) );  //  in days
 }
 document.cookie = name + '=' + escape( value ) +
  ( expiry ? '; expires=' + now.toGMTString() : '' ) +
  ( path ? '; path=' + path : '' ) +
  ( domain ? '; domain=' + domain : '' );
}

function getcookie( name ) { name += '=';
 var cookies = document.cookie, i = cookies.indexOf( name ), j, start, end;
 if( i < 0 ) { return null; }
 start = i + name.length;
 end = cookies.substring( start );
 j = end.indexOf( ';' );
 end = j < 0 ? cookies.length : start + j;
 return unescape( cookies.substring( start, end ) );
}

addevent( 'load', loaded );
