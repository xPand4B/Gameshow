(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{ZFEL:function(t,e,n){"use strict";n.d(e,"a",(function(){return b})),n.d(e,"b",(function(){return m}));var a=n("L2JU");function r(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,a)}return n}function i(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var s={name:"game-menu-playerListing",computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?r(Object(n),!0).forEach((function(e){i(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):r(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},Object(a.c)(["getLobbyUser","getPlayerName"]))},o=n("KHd+"),l=Object(o.a)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-row",[n("v-slide-y-transition",{attrs:{group:""}},t._l(t.getLobbyUser,(function(e,a){return n("v-chip",{key:"lobby.user."+a,staticClass:"ma-2",attrs:{color:"primary",outlined:t.getPlayerName!==e.text}},[e.isGamemaster?n("i",{staticClass:"fas fa-crown fa-sm pr-2"}):t._e(),t._v("\n            "+t._s(e.text)+"\n        ")])})),1)],1)}),[],!1,null,null,null).exports,c=n("Uoid");function u(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,a)}return n}function d(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?u(Object(n),!0).forEach((function(e){p(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):u(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function p(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var f={name:"game-menu",components:{PlayerListing:l},data:function(){return{ApiRoutes:c.a,loading:!0,gameId:null,joinUrl:""}},props:{mainMenu:{type:Boolean,default:!1},customCard:{type:Boolean,default:!1},withCopyLink:{type:Boolean,default:!1},backLink:{type:String,default:null}},beforeMount:function(){this.mainMenu||this.fetchMe()},watch:{isLoading:{handler:function(t,e){!t&&e&&this.initValues()},deep:!0,immediate:!0},mainMenu:{handler:function(t,e){!t&&e&&this.fetchMe()},deep:!0,immediate:!0}},computed:d({},Object(a.c)(["getPlayerLoginSuccess"])),methods:d(d({},Object(a.b)(["fetchSingleGameData","setPlayerName","loginPlayer","lobbyInit","lobbyJoined","lobbyLeft"])),{},{fetchMe:function(){var t=this;axios.get(c.a.v1.auth.me).then((function(e){e.data.success?t.fetchSingleGameData(t.$route.params.id).then((function(){t.setPlayerName(e.data.playerName),t.initValues()})):t.enterPlayerName()})).catch((function(t){Toast.fire({icon:"error",title:t})}))},enterPlayerName:function(){var t=this;Swal.fire({icon:"question",title:"What's your username?",input:"text",allowOutsideClick:!1,preConfirm:function(e){e?e.length>20&&Swal.showValidationMessage(t.$t("validation.max-chars",{num:20})):Swal.showValidationMessage(t.$t("validation.required"))}}).then((function(e){t.loginPlayer(e.value.toString()).then((function(){t.fetchMe()}))}))},initValues:function(){var t=this;this.gameId=this.$route.params.id,this.joinUrl=window.location.href,this.loading=!1,Echo.join("Game.".concat(this.$route.params.id,".Lobby")).here((function(e){t.lobbyInit(e)})).joining((function(e){t.lobbyJoined(e)})).leaving((function(e){t.lobbyLeft(e)}))},handleCopySuccess:function(){Toast.fire({icon:"success",title:"Link has been copied!"})},changeRoute:function(t){this.$router.push({name:t,params:{id:this.$route.params.id}})}})},b=Object(o.a)(f,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"rounded-tl-xl pl-10 deep-purple lighten-1 white--text"},[n("v-card-title",{staticClass:"text-h3 px-0"},[t._t("title",[t._v("\n                !!! Missing title !!!\n            ")]),t._v(" "),n("br")],2)],1),t._v(" "),t.customCard?t._e():n("v-card-text",{staticClass:"mx-auto"},[t.loading?n("div",{staticClass:"text-center"},[n("v-progress-circular",{attrs:{indeterminate:"",color:"deep-purple lighten-1",size:70,width:7}})],1):n("v-container",{staticClass:"pb-0 px-6"},[t._t("content"),t._v(" "),t.withCopyLink?n("v-container",[n("v-row",[n("v-col",{staticClass:"px-0 pb-0",attrs:{cols:"9"}},[n("v-text-field",{ref:"joinUrl",attrs:{label:t.$t("menu.general.copy.label"),outlined:"",dense:"",disabled:"","aria-disabled":"true"},model:{value:t.joinUrl,callback:function(e){t.joinUrl=e},expression:"joinUrl"}})],1),t._v(" "),n("v-col",{staticClass:"px-0"},[n("v-btn",{directives:[{name:"clipboard",rawName:"v-clipboard",value:t.joinUrl,expression:"joinUrl"}],staticClass:"ml-4",attrs:{color:"info",block:""},on:{success:t.handleCopySuccess}},[n("i",{staticClass:"fas fa-copy pr-2"}),t._v("\n                            "+t._s(t.$t("menu.general.copy.buttonText"))+"\n                        ")])],1)],1),t._v(" "),n("div",[n("v-divider",{staticClass:"pb-3"}),t._v(" "),n("player-listing")],1)],1):t._e()],2)],1),t._v(" "),n("v-fade-transition",{attrs:{mode:"out-in"}},[t.loading&&t.customCard&&!t.mainMenu?n("div",{staticClass:"text-center py-5"},[n("v-progress-circular",{attrs:{indeterminate:"",color:"deep-purple lighten-1",size:70,width:7}})],1):t._t("default")],2),t._v(" "),t.backLink?n("v-card-actions",{staticClass:"grey lighten-2 rounded-br-xl"},[n("v-btn",{attrs:{text:""},on:{click:function(e){return t.changeRoute("gameshow.menu.index")}}},[n("i",{staticClass:"fas fa-2x fa-caret-left pr-3"}),t._v("\n            "+t._s(t.$t("navigation.back"))+"\n        ")])],1):t._e()],1)}),[],!1,null,null,null).exports,v={name:"game-menu-buttons",data:function(){return{gameId:null}},props:{routeName:{type:String,required:!0},text:{type:String,required:!0},icon:{type:String,default:null}},created:function(){this.gameId=this.$route.params.id},methods:{changeRoute:function(t){this.$router.push({name:t,params:{id:this.gameId}})}}},m=Object(o.a)(v,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-btn",{staticClass:"mb-8",attrs:{color:"indigo",elevation:"2",block:"","x-large":"",outlined:""},on:{click:function(e){return t.changeRoute(t.routeName)}}},[t.icon?n("i",{staticClass:"pr-2",class:t.icon}):t._e(),t._v("\n    "+t._s(t.text)+"\n")])}),[],!1,null,null,null).exports},sGyK:function(t,e,n){"use strict";n.r(e);var a={name:"pages-questions-index",components:{GameMenu:n("ZFEL").a},data:function(){return{tab:null,items:["01","02","03","04"]}}},r=n("KHd+"),i=Object(r.a)(a,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("game-menu",{attrs:{"back-link":"gameshow.menu.index"},scopedSlots:t._u([{key:"title",fn:function(){return[t._v("\n        "+t._s(t.$t("questions.title"))+"\n    ")]},proxy:!0},{key:"content",fn:function(){return[n("v-tabs",{attrs:{"fixed-tabs":"","show-arrows":""},model:{value:t.tab,callback:function(e){t.tab=e},expression:"tab"}},[t._l(t.items,(function(e){return n("v-tab",{key:e},[t._v("\n                "+t._s(e)+"\n            ")])})),t._v(" "),n("v-tab",{attrs:{disabled:""}},[n("v-icon",{domProps:{textContent:t._s("fas fa-plus")}})],1)],2),t._v(" "),n("v-divider",{staticClass:"pb-5"}),t._v(" "),n("v-textarea",{attrs:{label:t.$t("questions.form.question.label"),rows:"4",dense:"",outlined:"",required:"","aria-required":"true"}}),t._v(" "),n("v-divider",{staticClass:"pb-5"}),t._v(" "),n("v-card",{staticClass:"px-5 py-1",attrs:{elevation:"6",rounded:""}},[n("v-row",[n("v-col",{staticClass:"pb-0",attrs:{cols:"11"}},[n("v-textarea",{attrs:{label:t.$t("questions.form.answer.label"),rows:"3",dense:"",outlined:"",required:"","aria-required":"true"}})],1),t._v(" "),n("v-col",{staticClass:"pb-0 px-0"},[n("v-btn",{attrs:{icon:""}},[n("v-icon",{attrs:{color:"red darken-2"},domProps:{textContent:t._s("fas fa-times")}})],1)],1)],1),t._v(" "),n("v-row",[n("v-col",{staticClass:"py-0"},[n("v-textarea",{attrs:{label:t.$t("questions.form.answerNote.label"),hint:t.$t("questions.form.answerNote.hint"),rows:"1","persistent-hint":"",dense:"",outlined:""}})],1)],1),t._v(" "),n("v-row",[n("v-col",{staticClass:"py-0"},[n("v-checkbox",{attrs:{label:t.$t("questions.form.isCorrect.label")}})],1)],1)],1),t._v(" "),n("v-btn",{staticClass:"my-7",attrs:{elevation:"4",color:"deep-purple darken-1",block:"",outlined:""}},[n("v-icon",{staticClass:"pr-4",domProps:{textContent:t._s("fas fa-plus")}}),t._v("\n            "+t._s(t.$t("questions.form.addAnswer.button"))+"\n        ")],1)]},proxy:!0}])})}),[],!1,null,null,null);e.default=i.exports}}]);
//# sourceMappingURL=questions.a888d8761743ad8c4981.js.map