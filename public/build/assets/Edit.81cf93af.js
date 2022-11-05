import{_ as V,A as k}from"./AdminLayout.5fa73673.js";import{L as x,H as U,r as h,o as d,b as c,e as a,w as g,F as C,d as t,k as p,i as r,v as b,u as _,t as v,c as w,p as A,q as T,s as B,a as y}from"./app.013e25ce.js";import{P as S}from"./Pagination.0b1e04ca.js";import{V as q}from"./ValidationError.73bec915.js";import{C as E}from"./ckeditor.a80a8572.js";const L={components:{AdminLayout:k,Link:x,Pagination:S,ValidationError:q,Head:U},props:["turnirQuestion"],data(){return{editor:E,editorConfig:{},input_type:"input",categories:["\u0422\u04D9\u0440\u0431\u0438\u0435\u0448\u0456\u043B\u0435\u0440\u0433\u0435","\u04B0\u0441\u0442\u0430\u0437\u0434\u0430\u0440\u0493\u0430","\u041E\u049B\u0443\u0448\u044B\u043B\u0430\u0440\u0493\u0430","\u0421\u0442\u0443\u0434\u0435\u043D\u0442\u0442\u0435\u0440\u0433\u0435"]}},methods:{submit(){this.$inertia.put(route("admin.turnirAllQuestions.update",this.turnirQuestion.id),this.turnirQuestion,{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})},getCategory(l){switch(l){case 1:return"\u0422\u04D9\u0440\u0431\u0438\u0435\u0448\u0456\u043B\u0435\u0440\u0433\u0435";case 2:return"\u04B0\u0441\u0442\u0430\u0437\u0434\u0430\u0440\u0493\u0430";case 3:return"\u041E\u049B\u0443\u0448\u044B\u043B\u0430\u0440\u0493\u0430";case 4:return"\u0421\u0442\u0443\u0434\u0435\u043D\u0442\u0442\u0435\u0440\u0433\u0435"}},getAnswerOptionTextType(l){switch(l){case 1:return"A ";case 2:return"B ";case 3:return"C ";case 4:return"D "}}}},i=l=>(T("data-v-b4650ea3"),l=l(),B(),l),O=i(()=>t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u0421\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443")],-1)),I={class:"row mb-2"},M=i(()=>t("div",{class:"col-sm-6"},[t("h1",{class:"m-0"},"\u0422\u0443\u0440\u043D\u0438\u0440 \u0441\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443")],-1)),D={class:"col-sm-6"},N={class:"breadcrumb float-sm-right"},F={class:"breadcrumb-item"},H=["href"],P=i(()=>t("i",{class:"fas fa-dashboard"},null,-1)),R=y(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),j=[P,R],z={class:"breadcrumb-item"},G=["href"],J=i(()=>t("i",{class:"fas fa-dashboard"},null,-1)),K=y(" \u0421\u04B1\u0440\u0430\u049B\u0442\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 "),W=[J,K],X=i(()=>t("li",{class:"breadcrumb-item active"}," \u0422\u0443\u0440\u043D\u0438\u0440 \u0441\u04B1\u0440\u0430\u049B \u04E9\u0437\u0433\u0435\u0440\u0442\u0443 ",-1)),Y={class:"container-fluid"},Z={class:"card card-primary"},$={class:"card-body"},tt={class:"table table-bordered"},et={class:"odd even"},nt=i(()=>t("td",{class:"w-25"},[t("b",null,"\u0421\u04B1\u0440\u0430\u049B"),y(),t("i",{class:"red"},"*")],-1)),st={id:"turnirQuestion"},ot={key:0},it=i(()=>t("a",{class:"d-block mt-2",href:"https://latex.codecogs.com/eqneditor/editor.php",target:"_blank"},"Latex \u0444\u043E\u0440\u043C\u0443\u043B\u0430",-1)),lt={class:"odd even"},rt=i(()=>t("td",null,"\u0416\u0430\u0443\u0430\u043F \u043D\u04B1\u0441\u049B\u0430\u043B\u0430\u0440\u044B\u043D \u0435\u043D\u0433\u0456\u0437\u0456\u04A3\u0456\u0437:",-1)),dt={class:"d-flex align-items-center"},ut={class:"d-flex align-items-center mr-2"},at=i(()=>t("p",{class:"ml-2"},"- input",-1)),ct={class:"d-flex align-items-center"},mt=i(()=>t("p",{class:"ml-2"},"- ckeditor",-1)),_t={class:"odd even"},ft=i(()=>t("i",{class:"red"},"*",-1)),bt={class:"d-flex align-items-center"},pt={class:"odd even"},vt=i(()=>t("i",{class:"red"},"*",-1)),wt={class:"d-flex align-items-center"},yt={class:"odd even"},ht=i(()=>t("i",{class:"red"},"*",-1)),gt={class:"d-flex align-items-center"},Qt={class:"odd even"},Vt=i(()=>t("i",{class:"red"},"*",-1)),kt={class:"d-flex align-items-center"},xt={class:"odd even"},Ut=i(()=>t("td",null,[t("b",null,"\u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456/ \u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456 \u0435\u043C\u0435\u0441 ")],-1)),Ct={class:"custom-control custom-switch"},At=i(()=>t("label",{class:"custom-control-label",for:"customSwitch1"},"\u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456/\u0411\u0435\u043B\u0441\u0435\u043D\u0434\u0456 \u0435\u043C\u0435\u0441",-1)),Tt={class:"odd even"},Bt=i(()=>t("i",{class:"fa fa-trash"},null,-1)),St=y(" \u0422\u0430\u0437\u0430\u043B\u0430\u0443 "),qt=[Bt,St],Et={class:"card-footer"},Lt=i(()=>t("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1));function Ot(l,e,s,It,o,u){const f=h("ckeditor"),m=h("validation-error"),Q=h("AdminLayout");return d(),c(C,null,[O,a(Q,null,{breadcrumbs:g(()=>[t("div",I,[M,t("div",D,[t("ol",N,[t("li",F,[t("a",{href:l.route("admin.index")},j,8,H)]),t("li",z,[t("a",{href:l.route("admin.turnirAllQuestions.index")},W,8,G)]),X])])])]),default:g(()=>[t("div",Y,[t("div",Z,[t("form",{method:"post",onSubmit:e[20]||(e[20]=p((...n)=>u.submit&&u.submit(...n),["prevent"]))},[t("div",$,[t("form",{onSubmit:e[18]||(e[18]=p((...n)=>u.submit&&u.submit(...n),["prevent"]))},[t("table",tt,[t("tbody",null,[t("tr",et,[nt,t("td",st,[o.input_type==="ckeditor"?(d(),c("div",ot,[a(f,{editor:o.editor,modelValue:s.turnirQuestion.question,"onUpdate:modelValue":e[0]||(e[0]=n=>s.turnirQuestion.question=n),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"]),it])):r((d(),c("input",{key:1,"onUpdate:modelValue":e[1]||(e[1]=n=>s.turnirQuestion.question=n),type:"text",class:"form-control"},null,512)),[[b,s.turnirQuestion.question]]),a(m,{field:"text"})])]),t("tr",lt,[rt,t("td",null,[t("div",dt,[t("div",ut,[r(t("input",{"onUpdate:modelValue":e[2]||(e[2]=n=>o.input_type=n),type:"radio",class:"select-answer",value:"input"},null,512),[[_,o.input_type]]),at]),t("div",ct,[r(t("input",{"onUpdate:modelValue":e[3]||(e[3]=n=>o.input_type=n),type:"radio",class:"select-answer",value:"ckeditor"},null,512),[[_,o.input_type]]),mt])])])]),t("tr",_t,[t("td",null,[t("b",null,v(u.getAnswerOptionTextType(1)),1),ft]),t("td",null,[t("div",bt,[r(t("input",{"onUpdate:modelValue":e[4]||(e[4]=n=>s.turnirQuestion.correct_answer=n),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:"1"},null,512),[[_,s.turnirQuestion.correct_answer]]),o.input_type==="ckeditor"?(d(),w(f,{key:0,editor:o.editor,modelValue:s.turnirQuestion.answer1,"onUpdate:modelValue":e[5]||(e[5]=n=>s.turnirQuestion.answer1=n),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"])):r((d(),c("input",{key:1,"onUpdate:modelValue":e[6]||(e[6]=n=>s.turnirQuestion.answer1=n),type:"text",class:"form-control"},null,512)),[[b,s.turnirQuestion.answer1]])]),a(m,{field:`answers.${l.index}.text`},null,8,["field"])])]),t("tr",pt,[t("td",null,[t("b",null,v(u.getAnswerOptionTextType(2)),1),vt]),t("td",null,[t("div",wt,[r(t("input",{"onUpdate:modelValue":e[7]||(e[7]=n=>s.turnirQuestion.correct_answer=n),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:2},null,512),[[_,s.turnirQuestion.correct_answer]]),o.input_type==="ckeditor"?(d(),w(f,{key:0,editor:o.editor,modelValue:s.turnirQuestion.answer2,"onUpdate:modelValue":e[8]||(e[8]=n=>s.turnirQuestion.answer2=n),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"])):r((d(),c("input",{key:1,"onUpdate:modelValue":e[9]||(e[9]=n=>s.turnirQuestion.answer2=n),type:"text",class:"form-control"},null,512)),[[b,s.turnirQuestion.answer2]])]),a(m,{field:`answers.${l.index}.text`},null,8,["field"])])]),t("tr",yt,[t("td",null,[t("b",null,v(u.getAnswerOptionTextType(3)),1),ht]),t("td",null,[t("div",gt,[r(t("input",{"onUpdate:modelValue":e[10]||(e[10]=n=>s.turnirQuestion.correct_answer=n),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:3},null,512),[[_,s.turnirQuestion.correct_answer]]),o.input_type==="ckeditor"?(d(),w(f,{key:0,editor:o.editor,modelValue:s.turnirQuestion.answer3,"onUpdate:modelValue":e[11]||(e[11]=n=>s.turnirQuestion.answer3=n),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"])):r((d(),c("input",{key:1,"onUpdate:modelValue":e[12]||(e[12]=n=>s.turnirQuestion.answer3=n),type:"text",class:"form-control"},null,512)),[[b,s.turnirQuestion.answer3]])]),a(m,{field:`answers.${l.index}.text`},null,8,["field"])])]),t("tr",Qt,[t("td",null,[t("b",null,v(u.getAnswerOptionTextType(4)),1),Vt]),t("td",null,[t("div",kt,[r(t("input",{"onUpdate:modelValue":e[13]||(e[13]=n=>s.turnirQuestion.correct_answer=n),class:"select-answer mr-2 h-25",type:"radio",name:"Buttonradio25",value:4},null,512),[[_,s.turnirQuestion.correct_answer]]),o.input_type==="ckeditor"?(d(),w(f,{key:0,editor:o.editor,modelValue:s.turnirQuestion.answer4,"onUpdate:modelValue":e[14]||(e[14]=n=>s.turnirQuestion.answer4=n),config:o.editorConfig,class:"form-control"},null,8,["editor","modelValue","config"])):r((d(),c("input",{key:1,"onUpdate:modelValue":e[15]||(e[15]=n=>s.turnirQuestion.answer4=n),type:"text",class:"form-control"},null,512)),[[b,s.turnirQuestion.answer4]])]),a(m,{field:`answers.${l.index}.text`},null,8,["field"])])]),t("tr",xt,[Ut,t("td",null,[t("div",Ct,[r(t("input",{type:"checkbox","onUpdate:modelValue":e[16]||(e[16]=n=>s.turnirQuestion.question_active=n),"true-value":"1","false-value":"0",class:"custom-control-input",id:"customSwitch1"},null,512),[[A,s.turnirQuestion.question_active]]),At]),a(m,{field:"is_active"})])]),t("tr",Tt,[t("td",null,[t("button",{class:"btn btn-danger",type:"button",onClick:e[17]||(e[17]=p((...n)=>l.clear&&l.clear(...n),["prevent"]))},qt)])])])])],32)]),t("div",Et,[Lt,t("button",{type:"button",class:"btn btn-danger",onClick:e[19]||(e[19]=p(n=>l.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const Pt=V(L,[["render",Ot],["__scopeId","data-v-b4650ea3"]]);export{Pt as default};
