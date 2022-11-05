import{_ as u,A as h}from"./AdminLayout.5fa73673.js";import{L as b,H as f,r,o as p,b as v,e as i,w as c,F as g,d as s,k as d,i as y,v as S,a as l}from"./app.013e25ce.js";import{P as j}from"./Pagination.0b1e04ca.js";import{V as k}from"./ValidationError.73bec915.js";const q={components:{AdminLayout:h,Link:b,Pagination:j,ValidationError:k,Head:f},data(){return{qmgSubject:{name:null}}},methods:{submit(){this.$inertia.post(route("admin.qmgSubjects.store"),this.qmgSubject,{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})}}},w=s("head",null,[s("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u049A\u041C\u0416 \u043F\u04D9\u043D\u0434\u0435\u0440 \u049B\u043E\u0441\u0443")],-1),x={class:"row mb-2"},V=s("div",{class:"col-sm-6"},[s("h1",{class:"m-0"},"\u041F\u04D9\u043D \u049B\u043E\u0441\u0443")],-1),A={class:"col-sm-6"},L={class:"breadcrumb float-sm-right"},C={class:"breadcrumb-item"},B=["href"],E=s("i",{class:"fas fa-dashboard"},null,-1),N=l(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),T=[E,N],F={class:"breadcrumb-item"},H=["href"],M=s("i",{class:"fas fa-dashboard"},null,-1),P=l(" \u049A\u041C\u0416 \u043F\u04D9\u043D\u0434\u0435\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 "),$=[M,P],D=s("li",{class:"breadcrumb-item active"}," \u041F\u04D9\u043D \u049B\u043E\u0441\u0443 ",-1),U={class:"container-fluid"},z={class:"card card-primary"},G={class:"card-body"},I={class:"form-group"},J=s("label",{for:""},"\u0410\u0442\u044B",-1),K={class:"card-footer"},O=s("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1);function Q(e,t,R,W,a,n){const m=r("validation-error"),_=r("AdminLayout");return p(),v(g,null,[w,i(_,null,{breadcrumbs:c(()=>[s("div",x,[V,s("div",A,[s("ol",L,[s("li",C,[s("a",{href:e.route("admin.index")},T,8,B)]),s("li",F,[s("a",{href:e.route("admin.qmgSubjects.index")},$,8,H)]),D])])])]),default:c(()=>[s("div",U,[s("div",z,[s("form",{method:"post",onSubmit:t[2]||(t[2]=d((...o)=>n.submit&&n.submit(...o),["prevent"]))},[s("div",G,[s("div",I,[J,y(s("input",{type:"text",class:"form-control","onUpdate:modelValue":t[0]||(t[0]=o=>a.qmgSubject.name=o),name:"name",placeholder:"\u0410\u0442\u044B"},null,512),[[S,a.qmgSubject.name]]),i(m,{field:"name"})])]),s("div",K,[O,s("button",{type:"button",class:"btn btn-danger",onClick:t[1]||(t[1]=d(o=>e.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const ts=u(q,[["render",Q]]);export{ts as default};