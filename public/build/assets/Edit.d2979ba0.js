import{_ as U,A}from"./AdminLayout.aacb236b.js";import{L as S,H as L,r as v,o as a,b as i,e as u,w as g,F as w,d as t,k as b,t as d,a as n,g as V,i as r,v as f,u as k,f as T,p as x,c as B}from"./app.5a1bde93.js";import{P as E}from"./Pagination.8139c795.js";import{C as M}from"./ckeditor.8347b476.js";import{V as N}from"./ValidationError.f1f9254d.js";const D={components:{AdminLayout:A,Link:S,Pagination:E,ValidationError:N,Head:L},props:["surak","appeal"],data(){return{types:["\u041E\u0431\u043B\u044B\u0441\u0442\u044B\u049B","\u0420\u0435\u0441\u043F\u0443\u0431\u043B\u0438\u043A\u0430\u043B\u044B\u049B","\u0425\u0430\u043B\u044B\u049B\u0430\u0440\u0430\u043B\u044B\u049B"],bagyt_id:route().params.bagyt,option_id:route().params.option,editor:M,input_type:"input",editorConfig:{}}},methods:{submit(){this.$inertia.put(route("admin.olimpiadaAppeals.update",[this.appeal.id]),{surak:this.surak,appeal:this.appeal},{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})},getAnswerOptionTextType(c){switch(c){case 1:return"A ";case 2:return"B ";case 3:return"C ";case 4:return"D ";case 5:return"E ";case 6:return"F ";case 7:return"G ";case 8:return"H ";case 9:return"J "}}}},F=t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 | \u0421\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443")],-1),H={class:"row mb-2"},O=t("div",{class:"col-sm-6"},[t("h1",{class:"m-0"},"\u0421\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443")],-1),P={class:"col-sm-6"},q={class:"breadcrumb float-sm-right"},G={class:"breadcrumb-item"},J=["href"],Q=t("i",{class:"fas fa-dashboard"},null,-1),R=n(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),j=[Q,R],z={class:"breadcrumb-item"},I=["href"],K=t("i",{class:"fas fa-dashboard"},null,-1),W=n(" \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 \u0431\u0430\u0493\u044B\u0442 "),X=[K,W],Y=t("li",{class:"breadcrumb-item active"},"\u0421\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443",-1),Z={class:"container-fluid"},$={class:"card card-primary"},tt={class:"card-footer"},st=t("div",{class:"card-header"},[t("h3",{class:"card-title"}," \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430\u0493\u0430 \u049B\u0430\u0442\u044B\u0441\u0443 \u0436\u0430\u0439\u043B\u044B \u0430\u049B\u043F\u0430\u0440\u0430\u0442 ")],-1),et={class:"card-body"},ot={class:"row"},lt={class:"col-12 col-md-12 col-lg-12 order-2 order-md-1"},at={class:"row"},nt={class:"col-12"},it={key:0,class:"post"},dt={class:"user-block"},rt={class:"username",style:{"margin-left":"0 !important"}},ct={class:"mb-0"},ut=t("b",null,"\u041A\u0430\u0442\u0435\u0433\u043E\u0440\u0438\u044F:",-1),_t={class:"mb-0"},mt=t("b",null,"\u0411\u0430\u0493\u044B\u0442:",-1),ht={class:"mb-0"},pt=t("b",null,"\u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 \u0442\u04AF\u0440\u0456:",-1),bt={class:"mb-0 mt-3"},vt=t("b",null,"\u049A\u0430\u0442\u0435 \u0442\u04AF\u0440\u0456:",-1),ft={key:0,class:"mb-0"},kt=t("b",null,"\u041A\u043E\u043C\u043C\u0435\u043D\u0442\u0430\u0440\u0438\u0438:",-1),yt={class:"card-body"},gt={class:"table table-bordered"},wt={class:"odd even"},Vt=t("td",{class:"w-25"},[t("b",null,"\u0421\u04B1\u0440\u0430\u049B"),n(),t("i",{class:"red"},"*")],-1),xt={id:"turnirQuestion"},Ct={key:0},Ut=t("a",{class:"d-block mt-2",href:"https://latex.codecogs.com/eqneditor/editor.php",target:"_blank"},"Latex \u0444\u043E\u0440\u043C\u0443\u043B\u0430",-1),At={class:"odd even"},St=t("td",null,"\u0416\u0430\u0443\u0430\u043F \u043D\u04B1\u0441\u049B\u0430\u043B\u0430\u0440\u044B\u043D \u0435\u043D\u0433\u0456\u0437\u0456\u04A3\u0456\u0437:",-1),Lt={class:"d-flex align-items-center"},Tt={class:"d-flex align-items-center mr-2"},Bt=t("p",{class:"ml-2"},"- input",-1),Et={class:"d-flex align-items-center"},Mt=t("p",{class:"ml-2"},"- ckeditor",-1),Nt=t("i",{class:"red"},"*",-1),Dt={class:"d-flex align-items-center"},Ft=["value"],Ht=["onUpdate:modelValue"],Ot={class:"odd even"},Pt=t("td",null,[t("b",null,"\u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456/ \u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456 \u0435\u043C\u0435\u0441 ")],-1),qt={class:"custom-control custom-switch"},Gt=t("label",{class:"custom-control-label",for:"customSwitch1"},"\u0410\u0440\u0445\u0438\u0432",-1),Jt={class:"odd even"},Qt=t("i",{class:"fa fa-trash"},null,-1),Rt=n(" \u0422\u0430\u0437\u0430\u043B\u0430\u0443 "),jt=[Qt,Rt],zt={class:"form-group"},It=t("label",{for:""},"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A",-1),Kt={class:"form-group mt-5"},Wt={class:"custom-control custom-switch"},Xt={class:"custom-control-label",for:"customSwitch2"},Yt={class:"card-footer"},Zt=t("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1);function $t(c,e,o,ts,l,_){const y=v("ckeditor"),m=v("validation-error"),C=v("AdminLayout");return a(),i(w,null,[F,u(C,null,{breadcrumbs:g(()=>[t("div",H,[O,t("div",P,[t("ol",q,[t("li",G,[t("a",{href:c.route("admin.index")},j,8,J)]),t("li",z,[t("a",{href:c.route("admin.olimpiadaAppeals.index",[l.bagyt_id,l.option_id])},X,8,I)]),Y])])])]),default:g(()=>[t("div",Z,[t("div",$,[t("form",{method:"post",onSubmit:e[11]||(e[11]=b((...s)=>_.submit&&_.submit(...s),["prevent"]))},[t("div",tt,[st,t("div",et,[t("div",ot,[t("div",lt,[t("div",at,[t("div",nt,[o.surak.bagyty?(a(),i("div",it,[t("div",dt,[t("span",rt," \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 \u0430\u0442\u0430\u0443\u044B: "+d(o.surak.tury.o_tury),1)]),t("p",ct,[ut,n(" "+d(o.surak.bagyty.katysushilar),1)]),t("p",_t,[mt,n(" "+d(o.surak.bagyty.bagyt),1)]),t("p",ht,[pt,n(" "+d(l.types[o.surak.bagyty.type-1]),1)]),t("p",bt,[vt,n(" "+d(o.appeal.variable),1)]),o.appeal.text?(a(),i("p",ft,[kt,n(" "+d(o.appeal.text),1)])):V("",!0)])):V("",!0)])])])])])]),t("div",yt,[t("form",{onSubmit:e[8]||(e[8]=b((...s)=>_.submit&&_.submit(...s),["prevent"]))},[t("table",gt,[t("tbody",null,[t("tr",wt,[Vt,t("td",xt,[l.input_type==="ckeditor"?(a(),i("div",Ct,[u(y,{editor:l.editor,modelValue:o.surak.surak,"onUpdate:modelValue":e[0]||(e[0]=s=>o.surak.surak=s),config:l.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"]),Ut])):r((a(),i("input",{key:1,"onUpdate:modelValue":e[1]||(e[1]=s=>o.surak.surak=s),type:"text",class:"form-control"},null,512)),[[f,o.surak.surak]]),u(m,{field:"surak"})])]),t("tr",At,[St,t("td",null,[t("div",Lt,[t("div",Tt,[r(t("input",{"onUpdate:modelValue":e[2]||(e[2]=s=>l.input_type=s),type:"radio",class:"select-answer",value:"input"},null,512),[[k,l.input_type]]),Bt]),t("div",Et,[r(t("input",{"onUpdate:modelValue":e[3]||(e[3]=s=>l.input_type=s),type:"radio",class:"select-answer",value:"ckeditor"},null,512),[[k,l.input_type]]),Mt])])])]),(a(!0),i(w,null,T(o.surak.zhauap,(s,p)=>(a(),i("tr",{key:"zhauap"+p,class:"odd even"},[t("td",null,[t("b",null,d(_.getAnswerOptionTextType(p+1)),1),Nt]),t("td",null,[t("div",Dt,[r(t("input",{"onUpdate:modelValue":e[4]||(e[4]=h=>o.surak.correct_answer_number=h),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:p},null,8,Ft),[[k,o.surak.correct_answer_number]]),l.input_type==="ckeditor"?(a(),B(y,{key:0,editor:l.editor,modelValue:s.variant,"onUpdate:modelValue":h=>s.variant=h,config:l.editorConfig,class:"form-control"},null,8,["editor","modelValue","onUpdate:modelValue","config"])):r((a(),i("input",{key:1,"onUpdate:modelValue":h=>s.variant=h,type:"text",class:"form-control"},null,8,Ht)),[[f,s.variant]])]),u(m,{field:`zhauaptar.${p}.variant`},null,8,["field"])])]))),128)),t("tr",Ot,[Pt,t("td",null,[t("div",qt,[r(t("input",{type:"checkbox","onUpdate:modelValue":e[5]||(e[5]=s=>o.surak.archive=s),"true-value":"1","false-value":"0",class:"custom-control-input",id:"customSwitch1"},null,512),[[x,o.surak.archive]]),Gt]),u(m,{field:"is_active"})])]),t("tr",Jt,[t("td",null,[t("button",{class:"btn btn-danger",type:"button",onClick:e[6]||(e[6]=b((...s)=>c.clear&&c.clear(...s),["prevent"]))},jt)])])])]),t("div",zt,[It,r(t("input",{type:"text",class:"form-control","onUpdate:modelValue":e[7]||(e[7]=s=>o.surak.tusinik=s),name:"name",placeholder:"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A"},null,512),[[f,o.surak.tusinik]]),u(m,{field:"tusinik"})])],32),t("div",Kt,[t("div",Wt,[r(t("input",{type:"checkbox","onUpdate:modelValue":e[9]||(e[9]=s=>o.appeal.is_checked=s),class:"custom-control-input",id:"customSwitch2","true-value":"1","false-value":"0"},null,512),[[x,o.appeal.is_checked]]),t("label",Xt,"\u0422\u0435\u043A\u0441\u0435\u0440\u0456\u043B\u0434\u0456 ("+d(o.appeal.is_checked==1?"\u0418\u04D9":"\u0416\u043E\u049B")+")",1)]),u(m,{field:"active"})])]),t("div",Yt,[Zt,t("button",{type:"button",class:"btn btn-danger",onClick:e[10]||(e[10]=b(s=>c.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const ns=U(D,[["render",$t]]);export{ns as default};