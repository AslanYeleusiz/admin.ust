import{_ as A,A as B}from"./AdminLayout.5fa73673.js";import{L,H as T,r as m,o as r,b as d,e as _,w as c,F as f,d as e,i as p,j as g,k as b,f as x,v as V,l as P,a as y,t as i,n as S}from"./app.013e25ce.js";import{P as D}from"./Pagination.0b1e04ca.js";const M={components:{AdminLayout:B,Link:L,Head:T,Pagination:D},props:["appeals"],data(){var l,s,o,h,n;return{filter:{username:(l=route().params.username)!=null?l:null,surak:(s=route().params.surak)!=null?s:null,variable:(o=route().params.variable)!=null?o:null,text:(h=route().params.text)!=null?h:null,is_checked:(n=route().params.is_checked)!=null?n:null},appeal_types:[{name:"\u0421\u04B1\u0440\u0430\u049B\u0442\u0430 \u0433\u0440\u0430\u043C\u043C\u0430\u0442\u0438\u043A\u0430\u043B\u044B\u049B \u049B\u0430\u0442\u0435 \u0431\u0430\u0440"},{name:"\u0416\u0430\u0443\u0430\u0431\u044B \u049B\u0430\u0442\u0435"},{name:"\u0421\u04B1\u0440\u0430\u049B\u0442\u044B\u04A3 \u043C\u0430\u0437\u043C\u04B1\u043D\u044B\u043D\u0434\u0430 \u049B\u0430\u0442\u0435\u043B\u0456\u043A \u0431\u0430\u0440"},{name:"\u0416\u0430\u0443\u0430\u043F \u043D\u04B1\u0441\u049B\u0430\u043B\u0430\u0440\u044B \u0431\u0456\u0440\u0434\u0435\u0439"},{name:"\u0411\u0430\u0441\u049B\u0430 \u049B\u0430\u0442\u0435\u043B\u0435\u0440"}]}},mounted(){console.log(this.appeals)},methods:{deleteData(l){Swal.fire({title:"\u0416\u043E\u044E\u0493\u0430 \u0441\u0435\u043D\u0456\u043C\u0434\u0456\u0441\u0456\u0437 \u0431\u0435?",text:"\u049A\u0430\u0439\u0442\u044B\u043F \u049B\u0430\u043B\u043F\u044B\u043D\u0430 \u043A\u0435\u043B\u043C\u0435\u0443\u0456 \u043C\u04AF\u043C\u043A\u0456\u043D!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"\u0418\u04D9, \u0436\u043E\u044F\u043C\u044B\u043D!",cancelButtonText:"\u0416\u043E\u049B"}).then(s=>{s.isConfirmed&&this.$inertia.delete(route("admin.olimpiadaAppeals.destroy",l))})},getStatusText(l){return l==0?"\u049A\u0430\u0440\u0430\u043B\u043C\u0430\u0493\u0430\u043D":l==1?"\u0422\u0435\u043A\u0441\u0435\u0440\u0456\u043B\u0433\u0435\u043D":"\u0410\u043D\u044B\u049B\u0442\u0430\u043B\u043C\u0430\u0493\u0430\u043D"},search(){const l=this.clearParams(this.filter);this.$inertia.get(route("admin.olimpiadaAppeals.index"),l)}}},N=e("head",null,[e("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u0422\u0435\u0441\u0442 \u0430\u043F\u0435\u043B\u044F\u0446\u0438\u044F")],-1),U={class:"row mb-2"},F=e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"},"\u0422\u0435\u0441\u0442 \u0430\u043F\u0435\u043B\u044F\u0446\u0438\u044F \u0442\u0456\u0437\u0456\u043C\u0456")],-1),H={class:"col-sm-6"},K={class:"breadcrumb float-sm-right"},j={class:"breadcrumb-item"},z=["href"],E=e("i",{class:"fas fa-dashboard"},null,-1),I=y(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),q=[E,I],G=e("li",{class:"breadcrumb-item active"}," \u0422\u0435\u0441\u0442 \u0430\u043F\u0435\u043B\u044F\u0446\u0438\u044F \u0442\u0456\u0437\u0456\u043C\u0456 ",-1),J={class:"buttons"},O=e("i",{class:"fa fa-trash"},null,-1),Q=y(" \u0424\u0438\u043B\u044C\u0442\u0440\u0434\u0456 \u0442\u0430\u0437\u0430\u043B\u0430\u0443 "),R={class:"container-fluid"},W={class:"card"},X={class:"card-body"},Y={class:"row"},Z={class:"col-sm-12"},$={class:"table table-hover table-bordered table-striped dataTable dtr-inline"},ee=e("tr",{role:"row"},[e("th",null,"\u2116"),e("th",null,"\u0410\u0442\u044B-\u0436\u04E9\u043D\u0456"),e("th",null,"\u0421\u04B1\u0440\u0430\u049B"),e("th",null,"\u049A\u0430\u0442\u0435 \u0442\u04AF\u0440\u0456"),e("th",null,"\u041A\u043E\u043C\u043C\u0435\u043D\u0442\u0430\u0440\u0438\u044F"),e("th",null,"\u0421\u0442\u0430\u0442\u0443\u0441"),e("th",null,"\u04D8\u0440\u0435\u043A\u0435\u0442")],-1),te={class:"filters"},se=e("td",null,null,-1),le=e("td",null,null,-1),ne=e("td",null,null,-1),oe=e("option",{value:null,selected:""}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B",-1),ae=["value"],ie=e("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),re=e("option",{value:"0"}," \u049A\u0430\u0440\u0430\u043B\u043C\u0430\u0493\u0430\u043D ",-1),de=e("option",{value:"1"}," \u0422\u0435\u043A\u0441\u0435\u0440\u0456\u043B\u0434\u0456 ",-1),ce=[ie,re,de],ue=e("td",null,null,-1),_e={class:"btn-group btn-group-sm"},he=e("i",{class:"fas fa-edit"},null,-1),me=["onClick"],fe=e("i",{class:"fas fa-times"},null,-1),pe=[fe];function be(l,s,o,h,n,a){const v=m("Link"),w=m("Pagination"),C=m("AdminLayout");return r(),d(f,null,[N,_(C,null,{breadcrumbs:c(()=>[e("div",U,[F,e("div",H,[e("ol",K,[e("li",j,[e("a",{href:l.route("admin.index")},q,8,z)]),G])])])]),header:c(()=>[e("div",J,[_(v,{class:"btn btn-danger",href:l.route("admin.olimpiadaAppeals.index")},{default:c(()=>[O,Q]),_:1},8,["href"])])]),default:c(()=>[e("div",R,[e("div",W,[e("div",X,[e("div",Y,[e("div",Z,[e("table",$,[e("thead",null,[ee,e("tr",te,[se,le,ne,e("td",null,[p(e("select",{"onUpdate:modelValue":s[0]||(s[0]=t=>n.filter.variable=t),class:"form-control",onChange:s[1]||(s[1]=b((...t)=>a.search&&a.search(...t),["prevent"]))},[oe,(r(!0),d(f,null,x(n.appeal_types,(t,u)=>(r(),d("option",{value:t.name,key:"appeal_types"+u},i(t.name),9,ae))),128))],544),[[g,n.filter.variable]])]),e("td",null,[p(e("input",{"onUpdate:modelValue":s[2]||(s[2]=t=>n.filter.text=t),class:"form-control",placeholder:"\u041A\u043E\u043C\u043C\u0435\u043D\u0442\u0430\u0440\u0438\u044F",onKeyup:s[3]||(s[3]=P((...t)=>a.search&&a.search(...t),["enter"]))},null,544),[[V,n.filter.text]])]),e("td",null,[p(e("select",{class:"form-control",onChange:s[4]||(s[4]=b(t=>a.search(),["prevent"])),"onUpdate:modelValue":s[5]||(s[5]=t=>n.filter.is_checked=t),placeholder:"\u0421\u0442\u0430\u0442\u0443\u0441"},ce,544),[[g,n.filter.is_checked]])]),ue])]),e("tbody",null,[(r(!0),d(f,null,x(o.appeals.data,(t,u)=>{var k;return r(),d("tr",{class:"odd",key:"appeal"+t.id},[e("td",null,i(o.appeals.from?o.appeals.from+u:u+1),1),e("td",null,i((k=t.user)==null?void 0:k.fio),1),e("td",null,i(t.surak.surak),1),e("td",null,i(t.variable),1),e("td",null,i(t.text),1),e("td",null,[e("span",{class:S(["badge badge-success",{"badge-success":t.is_checked==1,"badge-warning":t.is_checked==0}])},i(a.getStatusText(t.is_checked)),3)]),e("td",null,[e("div",_e,[_(v,{href:l.route("admin.olimpiadaAppeals.edit",t.id),class:"btn btn-primary",title:"\u0422\u0435\u0441\u0442 \u0441\u04B1\u0440\u0430\u0493\u044B\u043D \u04E9\u0437\u0433\u0435\u0440\u0442\u0443"},{default:c(()=>[he]),_:2},1032,["href"]),e("button",{onClick:b(ve=>a.deleteData(t.id),["prevent"]),class:"btn btn-danger",title:"\u0416\u043E\u044E"},pe,8,me)])])])}),128))])])])]),_(w,{links:o.appeals.links},null,8,["links"])])])])]),_:1})],64)}const ye=A(M,[["render",be]]);export{ye as default};
