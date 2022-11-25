import{_ as w,A as x}from"./AdminLayout.aacb236b.js";import{L as C,H as U,r as b,o as a,b as r,e as d,w as y,F as g,d as t,k as p,i as l,v as f,u as v,f as A,p as S,a as h,t as L,c as T}from"./app.5a1bde93.js";import{P as B}from"./Pagination.8139c795.js";import{C as E}from"./ckeditor.8347b476.js";import{V as M}from"./ValidationError.f1f9254d.js";const D={components:{AdminLayout:x,Link:C,Pagination:B,ValidationError:M,Head:U},props:["surak"],data(){return{bagyt_id:route().params.bagyt,option_id:route().params.option,editor:E,input_type:"input",editorConfig:{}}},methods:{submit(){this.$inertia.put(route("admin.olimpiadaSuraktar.update",[this.bagyt_id,this.option_id,this.surak.id]),this.surak,{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})},getAnswerOptionTextType(i){switch(i){case 1:return"A ";case 2:return"B ";case 3:return"C ";case 4:return"D ";case 5:return"E ";case 6:return"F ";case 7:return"G ";case 8:return"H ";case 9:return"J "}}}},F=t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 | \u0421\u04B1\u0440\u0430\u049B \u049B\u043E\u0441\u0443")],-1),H={class:"row mb-2"},N=t("div",{class:"col-sm-6"},[t("h1",{class:"m-0"},"\u0421\u04B1\u0440\u0430\u049B \u049B\u043E\u0441\u0443")],-1),O={class:"col-sm-6"},P={class:"breadcrumb float-sm-right"},q={class:"breadcrumb-item"},G=["href"],J=t("i",{class:"fas fa-dashboard"},null,-1),Q=h(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),R=[J,Q],j={class:"breadcrumb-item"},z=["href"],I=t("i",{class:"fas fa-dashboard"},null,-1),K=h(" \u041E\u043B\u0438\u043C\u043F\u0438\u0430\u0434\u0430 \u0431\u0430\u0493\u044B\u0442 "),W=[I,K],X=t("li",{class:"breadcrumb-item active"},"\u0421\u04B1\u0440\u0430\u049B \u049B\u043E\u0441\u0443",-1),Y={class:"container-fluid"},Z={class:"card card-primary"},$={class:"card-body"},tt={class:"table table-bordered"},et={class:"odd even"},st=t("td",{class:"w-25"},[t("b",null,"\u0421\u04B1\u0440\u0430\u049B"),h(),t("i",{class:"red"},"*")],-1),ot={id:"turnirQuestion"},nt={key:0},it=t("a",{class:"d-block mt-2",href:"https://latex.codecogs.com/eqneditor/editor.php",target:"_blank"},"Latex \u0444\u043E\u0440\u043C\u0443\u043B\u0430",-1),at={class:"odd even"},lt=t("td",null,"\u0416\u0430\u0443\u0430\u043F \u043D\u04B1\u0441\u049B\u0430\u043B\u0430\u0440\u044B\u043D \u0435\u043D\u0433\u0456\u0437\u0456\u04A3\u0456\u0437:",-1),rt={class:"d-flex align-items-center"},dt={class:"d-flex align-items-center mr-2"},ct=t("p",{class:"ml-2"},"- input",-1),ut={class:"d-flex align-items-center"},_t=t("p",{class:"ml-2"},"- ckeditor",-1),mt=t("i",{class:"red"},"*",-1),pt={class:"d-flex align-items-center"},ht=["value"],bt=["onUpdate:modelValue"],ft={class:"odd even"},vt=t("td",null,[t("b",null,"\u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456/ \u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456 \u0435\u043C\u0435\u0441 ")],-1),kt={class:"custom-control custom-switch"},yt=t("label",{class:"custom-control-label",for:"customSwitch1"},"\u0410\u0440\u0445\u0438\u0432",-1),gt={class:"odd even"},Vt=t("i",{class:"fa fa-trash"},null,-1),wt=h(" \u0422\u0430\u0437\u0430\u043B\u0430\u0443 "),xt=[Vt,wt],Ct={class:"form-group"},Ut=t("label",{for:""},"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A",-1),At={class:"card-footer"},St=t("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1);function Lt(i,s,n,Tt,o,c){const k=b("ckeditor"),_=b("validation-error"),V=b("AdminLayout");return a(),r(g,null,[F,d(V,null,{breadcrumbs:y(()=>[t("div",H,[N,t("div",O,[t("ol",P,[t("li",q,[t("a",{href:i.route("admin.index")},R,8,G)]),t("li",j,[t("a",{href:i.route("admin.olimpiadaSuraktar.index",[o.bagyt_id,o.option_id])},W,8,z)]),X])])])]),default:y(()=>[t("div",Y,[t("div",Z,[t("form",{method:"post",onSubmit:s[10]||(s[10]=p((...e)=>c.submit&&c.submit(...e),["prevent"]))},[t("div",$,[t("form",{onSubmit:s[8]||(s[8]=p((...e)=>c.submit&&c.submit(...e),["prevent"]))},[t("table",tt,[t("tbody",null,[t("tr",et,[st,t("td",ot,[o.input_type==="ckeditor"?(a(),r("div",nt,[d(k,{editor:o.editor,modelValue:n.surak.surak,"onUpdate:modelValue":s[0]||(s[0]=e=>n.surak.surak=e),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"]),it])):l((a(),r("input",{key:1,"onUpdate:modelValue":s[1]||(s[1]=e=>n.surak.surak=e),type:"text",class:"form-control"},null,512)),[[f,n.surak.surak]]),d(_,{field:"surak"})])]),t("tr",at,[lt,t("td",null,[t("div",rt,[t("div",dt,[l(t("input",{"onUpdate:modelValue":s[2]||(s[2]=e=>o.input_type=e),type:"radio",class:"select-answer",value:"input"},null,512),[[v,o.input_type]]),ct]),t("div",ut,[l(t("input",{"onUpdate:modelValue":s[3]||(s[3]=e=>o.input_type=e),type:"radio",class:"select-answer",value:"ckeditor"},null,512),[[v,o.input_type]]),_t])])])]),(a(!0),r(g,null,A(n.surak.zhauap,(e,m)=>(a(),r("tr",{key:"zhauap"+m,class:"odd even"},[t("td",null,[t("b",null,L(c.getAnswerOptionTextType(m+1)),1),mt]),t("td",null,[t("div",pt,[l(t("input",{"onUpdate:modelValue":s[4]||(s[4]=u=>n.surak.correct_answer_number=u),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:m},null,8,ht),[[v,n.surak.correct_answer_number]]),o.input_type==="ckeditor"?(a(),T(k,{key:0,editor:o.editor,modelValue:e.variant,"onUpdate:modelValue":u=>e.variant=u,config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","onUpdate:modelValue","config"])):l((a(),r("input",{key:1,"onUpdate:modelValue":u=>e.variant=u,type:"text",class:"form-control"},null,8,bt)),[[f,e.variant]])]),d(_,{field:`zhauaptar.${m}.variant`},null,8,["field"])])]))),128)),t("tr",ft,[vt,t("td",null,[t("div",kt,[l(t("input",{type:"checkbox","onUpdate:modelValue":s[5]||(s[5]=e=>n.surak.archive=e),"true-value":"1","false-value":"0",class:"custom-control-input",id:"customSwitch1"},null,512),[[S,n.surak.archive]]),yt]),d(_,{field:"is_active"})])]),t("tr",gt,[t("td",null,[t("button",{class:"btn btn-danger",type:"button",onClick:s[6]||(s[6]=p((...e)=>i.clear&&i.clear(...e),["prevent"]))},xt)])])])]),t("div",Ct,[Ut,l(t("input",{type:"text",class:"form-control","onUpdate:modelValue":s[7]||(s[7]=e=>n.surak.tusinik=e),name:"name",placeholder:"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A"},null,512),[[f,n.surak.tusinik]]),d(_,{field:"tusinik"})])],32)]),t("div",At,[St,t("button",{type:"button",class:"btn btn-danger",onClick:s[9]||(s[9]=p(e=>i.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const Ht=w(D,[["render",Lt]]);export{Ht as default};