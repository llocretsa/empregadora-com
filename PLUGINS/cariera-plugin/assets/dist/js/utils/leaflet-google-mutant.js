(self.webpackChunkcariera_plugin=self.webpackChunkcariera_plugin||[]).push([[133],{177:function(){!function(){"use strict";var t=Symbol("newer"),e=Symbol("older"),i=function(t,e){"number"!=typeof t&&(e=t,t=0),this.size=0,this.limit=t,this.oldest=this.newest=void 0,this._keymap=new Map,e&&(this.assign(e),t<1&&(this.limit=this.size))};function n(i,n){this.key=i,this.value=n,this[t]=void 0,this[e]=void 0}function o(t){this.entry=t}function s(t){this.entry=t}function a(t){this.entry=t}i.prototype._markEntryAsUsed=function(i){i!==this.newest&&(i[t]&&(i===this.oldest&&(this.oldest=i[t]),i[t][e]=i[e]),i[e]&&(i[e][t]=i[t]),i[t]=void 0,i[e]=this.newest,this.newest&&(this.newest[t]=i),this.newest=i)},i.prototype.assign=function(i){var o,s=this.limit||Number.MAX_VALUE;this._keymap.clear();for(var a=i[Symbol.iterator](),r=a.next();!r.done;r=a.next()){var l=new n(r.value[0],r.value[1]);if(this._keymap.set(l.key,l),o?(o[t]=l,l[e]=o):this.oldest=l,o=l,0==s--)throw new Error("overflow")}this.newest=o,this.size=this._keymap.size},i.prototype.get=function(t){var e=this._keymap.get(t);if(e)return this._markEntryAsUsed(e),e.value},i.prototype.set=function(i,o){var s=this._keymap.get(i);return s?(s.value=o,this._markEntryAsUsed(s),this):(this._keymap.set(i,s=new n(i,o)),this.newest?(this.newest[t]=s,s[e]=this.newest):this.oldest=s,this.newest=s,++this.size,this.size>this.limit&&this.shift(),this)},i.prototype.shift=function(){var i=this.oldest;if(i)return this.oldest[t]?(this.oldest=this.oldest[t],this.oldest[e]=void 0):(this.oldest=void 0,this.newest=void 0),i[t]=i[e]=void 0,this._keymap.delete(i.key),--this.size,[i.key,i.value]},i.prototype.find=function(t){var e=this._keymap.get(t);return e?e.value:void 0},i.prototype.has=function(t){return this._keymap.has(t)},i.prototype.delete=function(i){var n=this._keymap.get(i);if(n)return this._keymap.delete(n.key),n[t]&&n[e]?(n[e][t]=n[t],n[t][e]=n[e]):n[t]?(n[t][e]=void 0,this.oldest=n[t]):n[e]?(n[e][t]=void 0,this.newest=n[e]):this.oldest=this.newest=void 0,this.size--,n.value},i.prototype.clear=function(){this.oldest=this.newest=void 0,this.size=0,this._keymap.clear()},i.prototype.keys=function(){return new s(this.oldest)},i.prototype.values=function(){return new a(this.oldest)},i.prototype.entries=function(){return this},i.prototype[Symbol.iterator]=function(){return new o(this.oldest)},i.prototype.forEach=function(e,i){"object"!=typeof i&&(i=this);for(var n=this.oldest;n;)e.call(i,n.value,n.key,this),n=n[t]},i.prototype.toJSON=function(){for(var e=new Array(this.size),i=0,n=this.oldest;n;)e[i++]={key:n.key,value:n.value},n=n[t];return e},i.prototype.toString=function(){for(var e="",i=this.oldest;i;)e+=String(i.key)+":"+i.value,(i=i[t])&&(e+=" < ");return e},o.prototype[Symbol.iterator]=function(){return this},o.prototype.next=function(){var e=this.entry;return e?(this.entry=e[t],{done:!1,value:[e.key,e.value]}):{done:!0,value:void 0}},s.prototype[Symbol.iterator]=function(){return this},s.prototype.next=function(){var e=this.entry;return e?(this.entry=e[t],{done:!1,value:e.key}):{done:!0,value:void 0}},a.prototype[Symbol.iterator]=function(){return this},a.prototype.next=function(){var e=this.entry;return e?(this.entry=e[t],{done:!1,value:e.value}):{done:!0,value:void 0}},L.GridLayer.GoogleMutant=L.GridLayer.extend({options:{maxZoom:21,type:"roadmap",maxNativeZoom:21},initialize:function(t){L.GridLayer.prototype.initialize.call(this,t),this._tileCallbacks={},this._lru=new i(100),this._imagesPerTile="hybrid"===this.options.type?2:1,this._boundOnMutatedImage=this._onMutatedImage.bind(this)},onAdd:function(t){var e,i,n,o,s=this;L.GridLayer.prototype.onAdd.call(this,t),this._initMutantContainer(),this._logoContainer&&t._controlCorners.bottomleft.appendChild(this._logoContainer),this._attributionContainer&&t._controlCorners.bottomright.appendChild(this._attributionContainer),e=function(){s._map&&(s._initMutant(),google.maps.event.addListenerOnce(s._mutant,"idle",(function(){s._map&&(s._checkZoomLevels(),s._mutantIsReady=!0)})))},n=0,o=null,o=setInterval((function(){if(n>=20)throw clearInterval(o),new Error("window.google not found after 10 seconds");window.google&&window.google.maps&&window.google.maps.Map&&(clearInterval(o),e.call(i)),++n}),500)},onRemove:function(t){L.GridLayer.prototype.onRemove.call(this,t),this._observer.disconnect(),t._container.removeChild(this._mutantContainer),this._logoContainer&&L.DomUtil.remove(this._logoContainer),this._attributionContainer&&L.DomUtil.remove(this._attributionContainer),this._mutant&&google.maps.event.clearListeners(this._mutant,"idle")},addGoogleLayer:function(t,e){var i=this;return this._subLayers||(this._subLayers={}),this.whenReady((function(){var n=new(0,google.maps[t])(e);n.setMap(i._mutant),i._subLayers[t]=n})),this},removeGoogleLayer:function(t){var e=this;return this.whenReady((function(){var i=e._subLayers&&e._subLayers[t];i&&(i.setMap(null),delete e._subLayers[t])})),this},_initMutantContainer:function(){this._mutantContainer||(this._mutantContainer=L.DomUtil.create("div","leaflet-google-mutant leaflet-top leaflet-left"),this._mutantContainer.id="_MutantContainer_"+L.Util.stamp(this._mutantContainer),this._mutantContainer.style.pointerEvents="none",this._mutantContainer.style.visibility="hidden",L.DomEvent.off(this._mutantContainer)),this._map.getContainer().appendChild(this._mutantContainer),this.setOpacity(this.options.opacity);var t=this._mutantContainer.style;this._map.options.zoomSnap<1?(t.width="180%",t.height="180%"):(t.width="100%",t.height="100%"),t.zIndex=-1,this._attachObserver(this._mutantContainer)},_initMutant:function(){if(!this._mutant){var t=new google.maps.Map(this._mutantContainer,{center:{lat:0,lng:0},zoom:0,tilt:0,mapTypeId:this.options.type,disableDefaultUI:!0,keyboardShortcuts:!1,draggable:!1,disableDoubleClickZoom:!0,scrollwheel:!1,styles:this.options.styles||[],backgroundColor:"transparent"});this._mutant=t,this._update(),this.fire("spawned",{mapObject:t}),this._waitControls(),this.once("controls_ready",this._setupAttribution)}},_attachObserver:function(t){this._observer||(this._observer=new MutationObserver(this._onMutations.bind(this))),this._observer.observe(t,{childList:!0,subtree:!0}),Array.prototype.forEach.call(t.querySelectorAll("img"),this._boundOnMutatedImage)},_waitControls:function(){var t=this,e=setInterval((function(){var i,n=t._mutant.__gm.layoutManager;n&&(clearInterval(e),Object.keys(n).forEach((function(t){var e=n[t];e.get&&e.get(1)instanceof Node&&(i=e)})),t.fire("controls_ready",{positions:i}))}),50)},_setupAttribution:function(t){var e=google.maps.ControlPosition,i=this._attributionContainer=t.positions.get(e.BOTTOM_RIGHT);L.DomUtil.addClass(i,"leaflet-control leaflet-control-attribution"),L.DomEvent.disableClickPropagation(i),i.style.height="14px",this._map._controlCorners.bottomright.appendChild(i),this._logoContainer=t.positions.get(e.BOTTOM_LEFT),this._logoContainer.style.pointerEvents="auto",this._map._controlCorners.bottomleft.appendChild(this._logoContainer)},_onMutations:function(t){for(var e=0;e<t.length;++e)for(var i=t[e],n=0;n<i.addedNodes.length;++n){var o=i.addedNodes[n];o instanceof HTMLImageElement?this._onMutatedImage(o):o instanceof HTMLElement&&Array.prototype.forEach.call(o.querySelectorAll("img"),this._boundOnMutatedImage)}},_roadRegexp:/!1i(\d+)!2i(\d+)!3i(\d+)!/,_satRegexp:/x=(\d+)&y=(\d+)&z=(\d+)/,_staticRegExp:/StaticMapService\.GetMapImage/,_onMutatedImage:function(t){var e,i=t.src.match(this._roadRegexp),n=0;if(i?(e={z:i[1],x:i[2],y:i[3]},this._imagesPerTile>1&&(t.style.zIndex=1,n=1)):((i=t.src.match(this._satRegexp))&&(e={x:i[1],y:i[2],z:i[3]}),n=0),e){var o=this._tileCoordsToKey(e);t.style.position="absolute";var s=o+"/"+n;this._lru.set(s,t),s in this._tileCallbacks&&this._tileCallbacks[s]&&(this._tileCallbacks[s].forEach((function(e){return e(t)})),delete this._tileCallbacks[s])}},createTile:function(t,e){var i=this._tileCoordsToKey(t),n=L.DomUtil.create("div");n.style.textAlign="left",n.dataset.pending=this._imagesPerTile,e=e.bind(this,null,n);for(var o=0;o<this._imagesPerTile;++o){var s=i+"/"+o,a=this._lru.get(s);a?(n.appendChild(this._clone(a)),--n.dataset.pending):(this._tileCallbacks[s]=this._tileCallbacks[s]||[],this._tileCallbacks[s].push(function(t){return function(i){t.appendChild(this._clone(i)),--t.dataset.pending,parseInt(t.dataset.pending)||e()}.bind(this)}.bind(this)(n)))}return parseInt(n.dataset.pending)||L.Util.requestAnimFrame(e),n},_clone:function(t){var e=t.cloneNode(!0);return e.style.visibility="visible",e},_checkZoomLevels:function(){var t=this._map.getZoom(),e=this._mutant.getZoom();t&&e&&(e!==t||e>this.options.maxNativeZoom)&&this._setMaxNativeZoom(e)},_setMaxNativeZoom:function(t){t!==this.options.maxNativeZoom&&(this.options.maxNativeZoom=t,this._resetView())},_update:function(t){if(this._mutant){t=t||this._map.getCenter();var e=new google.maps.LatLng(t.lat,t.lng),i=Math.round(this._map.getZoom()),n=this._mutant.getZoom();this._mutant.setCenter(e),i!==n&&(this._mutant.setZoom(i),this._mutantIsReady&&this._checkZoomLevels())}L.GridLayer.prototype._update.call(this,t)},whenReady:function(t,e){return this._mutant?t.call(e||this,{target:this}):this.on("spawned",t,e),this}}),L.gridLayer.googleMutant=function(t){return new L.GridLayer.GoogleMutant(t)}}()}}]);