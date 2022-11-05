import{_ as y,A as V}from"./AdminLayout.5fa73673.js";import{L as k,H as x,r as p,o as u,b as m,e as l,w as h,F as f,d as s,k as b,i as r,v as i,z as U,j as v,f as S,p as _,a as d,t as C}from"./app.013e25ce.js";import{P as E}from"./Pagination.0b1e04ca.js";import{V as F}from"./ValidationError.73bec915.js";const L={components:{AdminLayout:V,Link:k,Pagination:E,ValidationError:F,Head:x},data(){return{user:{user_status_id:null,pol_id:null,balance:0,bonus:0,admin:!1},roles:["\u041F\u0435\u0434\u0430\u0433\u043E\u0433","\u041E\u049B\u0443\u0448\u044B","\u0411\u0430\u0441\u049B\u0430 (\u0430\u0442\u0430-\u0430\u043D\u0430 \u0442.\u0431.)"],passwordField:"password",passStat:!1}},methods:{submit(){this.$inertia.post(route("admin.users.store"),this.user,{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})},openPassword(){this.passStat=!this.passStat,this.passwordField=this.passwordField==="password"?"text":"password"}}},A=s("head",null,[s("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B \u049B\u043E\u0441\u0443")],-1),M={class:"row mb-2"},P=s("div",{class:"col-sm-6"},[s("h1",{class:"m-0"},"\u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B \u049B\u043E\u0441\u0443")],-1),B={class:"col-sm-6"},D={class:"breadcrumb float-sm-right"},N={class:"breadcrumb-item"},T=["href"],H=s("i",{class:"fas fa-dashboard"},null,-1),j=d(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),z=[H,j],q={class:"breadcrumb-item"},G=["href"],I=s("i",{class:"fas fa-dashboard"},null,-1),J=d(" \u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B\u043B\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 "),K=[I,J],O=s("li",{class:"breadcrumb-item active"}," \u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B \u049B\u043E\u0441\u0443 ",-1),Q={class:"container-fluid"},R={class:"card card-primary"},W={class:"card-body"},X={class:"form-group"},Y=s("label",{for:""},[d("\u0410\u0442\u044B-\u0436\u04E9\u043D\u0456 "),s("span",{class:"red"},"*")],-1),Z={class:"input-group"},$=s("div",{class:"input-group-prepend"},[s("span",{class:"input-group-text",id:""},"\u0422\u043E\u043B\u044B\u049B \u0430\u0442\u044B-\u0436\u04E9\u043D\u0456\u043D \u0435\u043D\u0433\u0456\u0437\u0456\u04A3\u0456\u0437")],-1),ss={class:"form-group"},os=s("label",{for:""},[d("Email "),s("span",{class:"red"},"*")],-1),es={class:"form-group"},ts=s("label",{for:""},[d("\u0422\u0435\u043B\u0435\u0444\u043E\u043D "),s("span",{class:"red"},"*")],-1),ls={class:"form-group"},ns=s("label",{for:""},[d("\u049A\u04B1\u043F\u0438\u044F\u0441\u04E9\u0437 "),s("span",{class:"red"},"*")],-1),rs=["type"],is={class:"form-group mt-1"},ds={class:"form-check"},as=s("label",{class:"form-check-label",for:"gridCheck"}," \u049A\u04B1\u043F\u0438\u044F \u0441\u04E9\u0437\u0434\u0456 \u043A\u04E9\u0440\u0441\u0435\u0442\u0443 ",-1),cs={class:"form-group"},us=s("label",{for:""},[d("\u0420\u04E9\u043B "),s("span",{class:"red"},"*")],-1),ms=s("option",{value:null,hidden:""}," \u0420\u04E9\u043B\u0434\u0456 \u0442\u0430\u04A3\u0434\u0430\u04A3\u044B\u0437 ",-1),_s=["value"],ps={class:"form-group"},hs=s("label",{for:""},"\u0422\u0443\u0493\u0430\u043D \u043A\u04AF\u043D\u0456",-1),fs={class:"form-group"},bs=s("label",{for:""},"\u0416\u044B\u043D\u044B\u0441\u044B",-1),vs=s("option",{value:"null"},"\u0416\u044B\u043D\u044B\u0441\u044B\u043D \u0442\u0430\u04A3\u0434\u0430\u04A3\u044B\u0437",-1),gs=s("option",{value:"1"},"\u0415\u0440",-1),ws=s("option",{value:"2"},"\u04D8\u0439\u0435\u043B",-1),ys=s("option",{value:"3"},"\u0411\u0430\u0441\u049B\u0430",-1),Vs=[vs,gs,ws,ys],ks={class:"row"},xs={class:"col-md-4"},Us={class:"form-group"},Ss=s("label",{for:""},"\u0411\u0430\u043B\u0430\u043D\u0441",-1),Cs={class:"input-group"},Es={class:"col-md-4"},Fs={class:"form-group"},Ls=s("label",{for:""},"\u0411\u043E\u043D\u0443\u0441",-1),As={class:"input-group"},Ms={class:"form-group"},Ps={class:"custom-control custom-switch"},Bs=s("label",{class:"custom-control-label",for:"customSwitch1"},"Email \u0440\u0430\u0441\u0442\u0430\u043B\u0493\u0430\u043D",-1),Ds={class:"form-group"},Ns={class:"custom-control custom-switch"},Ts=s("label",{class:"custom-control-label",for:"customSwitch2"},"\u0422\u0435\u043B\u0435\u0444\u043E\u043D \u0440\u0430\u0441\u0442\u0430\u043B\u0493\u0430\u043D",-1),Hs={class:"form-group"},js={class:"custom-control custom-switch"},zs=s("label",{class:"custom-control-label",for:"customSwitch3"},"\u0410\u0434\u043C\u0438\u043D",-1),qs={class:"card-footer"},Gs=s("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1);function Is(a,o,Js,Ks,t,c){const n=p("validation-error"),g=p("AdminLayout");return u(),m(f,null,[A,l(g,null,{breadcrumbs:h(()=>[s("div",M,[P,s("div",B,[s("ol",D,[s("li",N,[s("a",{href:a.route("admin.index")},z,8,T)]),s("li",q,[s("a",{href:a.route("admin.users.index")},K,8,G)]),O])])])]),default:h(()=>[s("div",Q,[s("div",R,[s("form",{method:"post",onSubmit:o[16]||(o[16]=b((...e)=>c.submit&&c.submit(...e),["prevent"]))},[s("div",W,[s("div",X,[Y,s("div",Z,[$,r(s("input",{type:"text",class:"form-control","onUpdate:modelValue":o[0]||(o[0]=e=>t.user.s_name=e),name:"s_name",placeholder:"\u0410\u0442\u044B"},null,512),[[i,t.user.s_name]]),r(s("input",{type:"text",class:"form-control","onUpdate:modelValue":o[1]||(o[1]=e=>t.user.username=e),placeholder:"\u0416\u04E9\u043D\u0456"},null,512),[[i,t.user.username]]),r(s("input",{type:"text",class:"form-control","onUpdate:modelValue":o[2]||(o[2]=e=>t.user.l_name=e),name:"l_name",placeholder:"\u04D8\u043A\u0435\u0441\u0456\u043D\u0456\u04A3 \u0430\u0442\u044B"},null,512),[[i,t.user.l_name]])]),l(n,{field:"username"}),l(n,{field:"s_name"}),l(n,{field:"l_name"})]),s("div",ss,[os,r(s("input",{type:"email",class:"form-control","onUpdate:modelValue":o[3]||(o[3]=e=>t.user.email=e),name:"",placeholder:"Email"},null,512),[[i,t.user.email]]),l(n,{field:"email"})]),s("div",es,[ts,r(s("input",{type:"text",class:"form-control","onUpdate:modelValue":o[4]||(o[4]=e=>t.user.tel_num=e),name:"phone",placeholder:"\u0422\u0435\u043B\u0435\u0444\u043E\u043D"},null,512),[[i,t.user.tel_num]]),l(n,{field:"tel_num"})]),s("div",ls,[ns,r(s("input",{type:t.passwordField,class:"form-control","onUpdate:modelValue":o[5]||(o[5]=e=>t.user.real_password=e),name:"password",autocomplete:"new-password",placeholder:"\u049A\u04B1\u043F\u0438\u044F\u0441\u04E9\u0437"},null,8,rs),[[U,t.user.real_password]]),s("div",is,[s("div",ds,[s("input",{class:"form-check-input",type:"checkbox",id:"gridCheck",onChange:o[6]||(o[6]=e=>c.openPassword())},null,32),as])]),l(n,{field:"real_password"})]),s("div",cs,[us,r(s("select",{class:"form-control","onUpdate:modelValue":o[7]||(o[7]=e=>t.user.user_status_id=e),name:"user_status_id"},[ms,(u(!0),m(f,null,S(t.roles,(e,w)=>(u(),m("option",{value:w},C(e),9,_s))),256))],512),[[v,t.user.user_status_id]]),l(n,{field:"user_status_id"})]),s("div",ps,[hs,r(s("input",{type:"date",class:"form-control","onUpdate:modelValue":o[8]||(o[8]=e=>t.user.birthday=e),name:"birthday",placeholder:"\u0422\u0443\u0493\u0430\u043D \u043A\u04AF\u043D\u0456"},null,512),[[i,t.user.birthday]]),l(n,{field:"birthday"})]),s("div",fs,[bs,r(s("select",{"onUpdate:modelValue":o[9]||(o[9]=e=>t.user.pol_id=e),class:"form-control",name:"pol_id"},Vs,512),[[v,t.user.pol_id]]),l(n,{field:"pol_id"})]),s("div",ks,[s("div",xs,[s("div",Us,[Ss,s("div",Cs,[r(s("input",{type:"number",class:"form-control","onUpdate:modelValue":o[10]||(o[10]=e=>t.user.balance=e),name:"balance",placeholder:"\u0411\u0430\u043B\u0430\u043D\u0441"},null,512),[[i,t.user.balance]])]),l(n,{field:"balance"})])]),s("div",Es,[s("div",Fs,[Ls,s("div",As,[r(s("input",{type:"number",class:"form-control","onUpdate:modelValue":o[11]||(o[11]=e=>t.user.bonus=e),placeholder:"\u0411\u043E\u043D\u0443\u0441"},null,512),[[i,t.user.bonus]])]),l(n,{field:"bonus"})])])]),s("div",Ms,[s("div",Ps,[r(s("input",{type:"checkbox","onUpdate:modelValue":o[12]||(o[12]=e=>t.user.email_rastalgan=e),class:"custom-control-input",id:"customSwitch1"},null,512),[[_,t.user.email_rastalgan]]),Bs]),l(n,{field:"email_rastalgan"})]),s("div",Ds,[s("div",Ns,[r(s("input",{type:"checkbox","onUpdate:modelValue":o[13]||(o[13]=e=>t.user.phone_activated=e),class:"custom-control-input",id:"customSwitch2"},null,512),[[_,t.user.phone_activated]]),Ts]),l(n,{field:"phone_activated"})]),s("div",Hs,[s("div",js,[r(s("input",{type:"checkbox","onUpdate:modelValue":o[14]||(o[14]=e=>t.user.admin=e),class:"custom-control-input",id:"customSwitch3"},null,512),[[_,t.user.admin]]),zs]),l(n,{field:"admin"})])]),s("div",qs,[Gs,s("button",{type:"button",class:"btn btn-danger",onClick:o[15]||(o[15]=b(e=>a.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const Xs=y(L,[["render",Is]]);export{Xs as default};