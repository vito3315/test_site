(function(a){var b=function(c){var d=c.h;if(!c.CORE_VERSION||!d.compareVersions(b.REQUIRE_CORE_VERSION,c.CORE_VERSION)){throw new Error("[MixItUp Multifilter] MixItUp Multifilter v"+b.EXTENSION_VERSION+" requires at least MixItUp v"+b.REQUIRE_CORE_VERSION)}c.ConfigMultifilter=function(){this.enable=false;this.logicWithinGroup="or";this.logicBetweenGroups="and";this.minSearchLength=3;this.parseOn="change";this.keyupThrottleDuration=350;d.seal(this)};c.Config.registerAction("beforeConstruct","multifilter",function(){this.multifilter=new c.ConfigMultifilter()});c.MultifilterFormEventTracker=function(){this.form=null;this.totalBound=0;this.totalHandled=0;d.seal(this)};c.FilterGroupDom=function(){this.el=null;this.form=null;d.seal(this)};c.FilterGroup=function(){this.dom=new c.FilterGroupDom();this.activeSelectors=[];this.activeToggles=[];this.handler=null;this.mixer=null;this.logic="or";this.parseOn="change";this.keyupTimeout=-1;d.seal(this)};d.extend(c.FilterGroup.prototype,{init:function(h,e){var g=this,f=h.getAttribute("data-logic");g.dom.el=h;g.cacheDom();if(g.dom.form){g.enableButtons()}g.mixer=e;if((f&&f.toLowerCase()==="and")||e.config.multifilter.logicWithinGroup==="and"){g.logic="and"}g.bindEvents()},cacheDom:function(){var e=this;e.dom.form=d.closestParent(e.dom.el,"form",true)},enableButtons:function(){var e=this,h=e.dom.form.querySelectorAll('button[type="submit"]:disabled'),g=null,f=-1;for(f=0;g=h[f];f++){if(g.disabled){g.disabled=false}}},bindEvents:function(){var e=this;e.handler=function(f){switch(f.type){case"reset":case"submit":e.handleFormEvent(f);break;default:e["handle"+d.pascalCase(f.type)](f)}};d.on(e.dom.el,"click",e.handler);d.on(e.dom.el,"change",e.handler);d.on(e.dom.el,"keyup",e.handler);if(e.dom.form){d.on(e.dom.form,"reset",e.handler);d.on(e.dom.form,"submit",e.handler)}},unbindEvents:function(){var e=this;d.off(e.dom.el,"click",e.handler);d.off(e.dom.el,"change",e.handler);d.off(e.dom.el,"keyup",e.handler);if(e.dom.form){d.off(e.dom.form,"reset",e.handler);d.off(e.dom.form,"submit",e.handler)}e.handler=null},handleClick:function(j){var h=this,g=d.closestParent(j.target,"[data-filter], [data-toggle]",true),i=-1,f="";if(!g){return}j.stopPropagation();if(g.matches("[data-filter]")){f=g.getAttribute("data-filter");h.activeSelectors=[f]}else{if(g.matches("[data-toggle]")){f=g.getAttribute("data-toggle");if((i=h.activeToggles.indexOf(f))>-1){h.activeToggles.splice(i,1)}else{h.activeToggles.push(f)}if(h.logic==="and"){h.activeSelectors=[h.activeToggles]}else{h.activeSelectors=h.activeToggles}}}h.updateControls();if(h.mixer.config.multifilter.parseOn==="change"){h.mixer.parseFilterGroups()}},handleChange:function(h){var g=this,f=h.target;h.stopPropagation();switch(f.type){case"text":case"search":case"password":case"select-one":case"radio":g.getSingleValue(f);break;case"checkbox":case"select-multiple":g.getMultipleValues(f);break}if(g.mixer.config.multifilter.parseOn==="change"){g.mixer.parseFilterGroups()}},handleKeyup:function(h){var g=this,f=h.target;if(g.mixer.config.multifilter.parseOn!=="change"){g.mixer.getSingleValue(f);return}clearTimeout(g.keyupTimeout);g.keyupTimeout=setTimeout(function(){g.getSingleValue(f);g.mixer.parseFilterGroups()},g.mixer.config.multifilter.keyupThrottleDuration)},handleFormEvent:function(k){var f=this,h=null,j=null,g=-1;k.preventDefault();if(k.type==="reset"){f.activeToggles=[];f.activeSelectors=[];f.updateControls()}if(!f.mixer.multifilterFormEventTracker){h=f.mixer.multifilterFormEventTracker=new c.MultifilterFormEventTracker();h.form=k.target;for(g=0;j=f.mixer.filterGroups[g];g++){if(j.dom.form!==k.target){continue}h.totalBound++}}else{h=f.mixer.multifilterFormEventTracker}if(k.target===h.form){h.totalHandled++;if(h.totalHandled===h.totalBound){f.mixer.multifilterFormEventTracker=null;if(k.type==="submit"||f.mixer.config.multifilter.parseOn==="change"){f.mixer.parseFilterGroups()}}}},getSingleValue:function(g){var f=this,h="",e="";if(g.type.match(/text|search|password/g)){h=g.getAttribute("data-search-attribute");if(!h){throw new Error("[MixItUp] A valid `data-search-attribute` must be present on text inputs")}if(g.value.length<f.mixer.config.multifilter.minSearchLength){f.activeSelectors=[""];return}e="["+h+'*="'+g.value+'"]'}else{e=g.value}if(g.value){f.activeSelectors=[e]}},getMultipleValues:function(g){var f=this,l=[],k="",j=null,e=null,h=-1;switch(g.type){case"checkbox":k='input[type="checkbox"]';break;case"select-multiple":k="option"}e=f.dom.el.querySelectorAll(k);for(h=0;j=e[h];h++){if((j.checked||j.selected)&&j.value){l.push(j.value)}}if(f.logic==="and"){l=[l]}f.activeSelectors=l},updateControls:function(){var f=this,h=f.dom.el.querySelectorAll("[data-filter], [data-toggle]"),e=null,j="filter",g=-1;for(g=0;e=h[g];g++){if(e.getAttribute("data-toggle")){j="toggle"}f.updateControl(e,j)}},updateControl:function(h,i){var g=this,e=h.getAttribute("data-"+i),f="";f=d.getClassname(g.mixer.config.classNames,i,g.mixer.config.classNames.modifierActive);if(g.activeSelectors.indexOf(e)>-1){d.addClass(h,f)}else{d.removeClass(h,f)}}});c.MixerDom.registerAction("afterConstruct","multifilter",function(){this.filterGroups=[]});c.Mixer.registerAction("afterConstruct","multifilter",function(){this.filterGroups=[];this.multifilterFormEventTracker=null});c.Mixer.registerAction("afterCacheDom","multifilter",function(){var e=this,f=null;if(!e.config.multifilter.enable){return}switch(e.config.controls.scope){case"local":f=e.dom.container;break;case"global":f=e.dom.document;break;default:throw new Error(c.messages.ERROR_CONFIG_INVALID_CONTROLS_SCOPE)}e.dom.filterGroups=f.querySelectorAll("[data-filter-group]")});c.Mixer.registerAction("beforeInitControls","multifilter",function(){var e=this;if(!e.config.multifilter.enable){return}e.config.controls.live=true});c.Mixer.registerAction("afterSanitizeConfig","multifilter",function(){var e=this;e.config.multifilter.logicBetweenGroups=e.config.multifilter.logicBetweenGroups.toLowerCase().trim();e.config.multifilter.logicWithinGroup=e.config.multifilter.logicWithinGroup.toLowerCase().trim()});c.Mixer.registerAction("afterAttach","multifilter",function(){var e=this;if(e.dom.filterGroups.length){e.indexFilterGroups()}});c.Mixer.registerAction("afterUpdateControls","multifilter",function(){var e=this,g=null,f=-1;for(f=0;g=e.filterGroups[f];f++){g.updateControls()}});c.Mixer.registerAction("beforeDestory","multifilter",function(){var e=this,g=null,f=-1;for(f=0;g=e.filterGroups[f];f++){g.unbindEvents()}});c.Mixer.extend({indexFilterGroups:function(){var f=this,e=null,h=null,g=-1;for(g=0;h=f.dom.filterGroups[g];g++){e=new c.FilterGroup();e.init(h,f);f.filterGroups.push(e)}},parseParseFilterGroupsArgs:function(h){var g=this,f=new c.UserInstruction(),e=null,j=-1;f.animate=g.config.animation.enable;f.command=new c.CommandFilter();for(j=0;j<h.length;j++){e=h[j];if(typeof e==="boolean"){f.animate=e}else{if(typeof e==="function"){f.callback=e}}}d.freeze(f);return f},parseFilterGroups:function(){var g=this,f=g.parseFilterArgs(arguments),h=g.getFilterGroupPaths(),e=g.buildSelectorFromPaths(h);if(e===""){e=g.config.controls.toggleDefault}f.command.selector=e;return g.multimix({filter:f.command},f.animate,f.callback)},getFilterGroupPaths:function(){var g=this,h=null,k=null,f=null,e=[],l=[],m=[],j=-1;for(j=0;j<g.filterGroups.length;j++){if((f=g.filterGroups[j].activeSelectors).length){e.push(f);m.push(0)}}h=function(){var o=null,p=[],n=-1;for(n=0;n<e.length;n++){o=e[n][m[n]];if(Array.isArray(o)){o=o.join("")}p.push(o)}p=d.clean(p);l.push(p)};k=function(n){n=n||0;var i=e[n];while(m[n]<i.length){if(n<e.length-1){k(n+1)}else{h()}m[n]++}m[n]=0};if(!e.length){return""}k();return l},buildSelectorFromPaths:function(l){var f=this,k=null,e=[],j="",h="",g=-1;if(!l.length){return""}if(f.config.multifilter.logicBetweenGroups==="or"){h=", "}if(l.length>1){for(g=0;g<l.length;g++){k=l[g];j=k.join(h);if(e.indexOf(j)<0){e.push(j)}}return e.join(", ")}else{return l[0].join(h)}}});c.Facade.registerAction("afterConstruct","multifilter",function(e){this.parseFilterGroups=e.parseFilterGroups.bind(e)})};b.TYPE="mixitup-extension";b.NAME="mixitup-multifilter";b.EXTENSION_VERSION="3.0.0-beta";b.REQUIRE_CORE_VERSION="3.0.0";if(typeof exports==="object"&&typeof module==="object"){module.exports=b}else{if(typeof define==="function"&&define.amd){define(function(){return b})}else{if(a.mixitup&&typeof a.mixitup==="function"){b(a.mixitup)}else{throw new Error("[MixItUp MultiFilter] MixItUp core not found")}}}})(window);