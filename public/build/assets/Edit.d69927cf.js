import{_ as h,A as b}from"./AdminLayout.5fa73673.js";import{L as f,H as p,r as n,o as v,b as S,e as r,w as d,F as y,d as t,t as c,k as l,i as j,v as g,a as m}from"./app.013e25ce.js";import{P as k}from"./Pagination.0b1e04ca.js";import{V as w}from"./ValidationError.73bec915.js";const x={components:{AdminLayout:b,Link:f,Pagination:k,ValidationError:w,Head:p},props:["materialSubject"],methods:{submit(){this.$inertia.put(route("admin.materialSubjects.update",this.materialSubject.id),this.materialSubject,{onError:()=>console.log("An error has occurred"),onSuccess:()=>console.log("The new contact has been saved")})}}},V=t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B \u0441\u044B\u043D\u044B\u0431\u044B\u043D \u04E9\u0437\u0433\u0435\u0440\u0442\u0443")],-1),A={class:"row mb-2"},L={class:"col-sm-6"},E={class:"m-0"},B={class:"col-sm-6"},C={class:"breadcrumb float-sm-right"},N={class:"breadcrumb-item"},T=["href"],D=t("i",{class:"fas fa-dashboard"},null,-1),F=m(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),H=[D,F],M={class:"breadcrumb-item"},P=["href"],U=t("i",{class:"fas fa-dashboard"},null,-1),q=m(" \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B \u043F\u04D9\u043D\u0434\u0435\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 "),z=[U,q],G={class:"breadcrumb-item active"},I={class:"container-fluid"},J={class:"card card-primary"},K={class:"card-body"},O={class:"form-group"},Q=t("label",{for:""},"\u0410\u0442\u044B",-1),R={class:"card-footer"},W=t("button",{type:"submit",class:"btn btn-primary mr-1"}," \u0421\u0430\u049B\u0442\u0430\u0443 ",-1);function X(a,s,e,Y,Z,i){const _=n("validation-error"),u=n("AdminLayout");return v(),S(y,null,[V,r(u,null,{breadcrumbs:d(()=>[t("div",A,[t("div",L,[t("h1",E,"\u041F\u04D9\u043D \u2116"+c(e.materialSubject.id),1)]),t("div",B,[t("ol",C,[t("li",N,[t("a",{href:a.route("admin.index")},H,8,T)]),t("li",M,[t("a",{href:a.route("admin.materialSubjects.index")},z,8,P)]),t("li",G," \u041F\u04D9\u043D \u2116"+c(e.materialSubject.id),1)])])])]),default:d(()=>[t("div",I,[t("div",J,[t("form",{method:"post",onSubmit:s[2]||(s[2]=l((...o)=>i.submit&&i.submit(...o),["prevent"]))},[t("div",K,[t("div",O,[Q,j(t("input",{type:"text",class:"form-control","onUpdate:modelValue":s[0]||(s[0]=o=>e.materialSubject.name=o),name:"name",placeholder:"\u0410\u0442\u044B"},null,512),[[g,e.materialSubject.name]]),r(_,{field:"name"})])]),t("div",R,[W,t("button",{type:"button",class:"btn btn-danger",onClick:s[1]||(s[1]=l(o=>a.back(),["prevent"]))}," \u0410\u0440\u0442\u049B\u0430 ")])],32)])])]),_:1})],64)}const ot=h(x,[["render",X]]);export{ot as default};