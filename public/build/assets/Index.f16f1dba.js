import{_ as C,A as V}from"./AdminLayout.5fa73673.js";import{L as D,H as L,r as f,o as a,b as i,e as h,w as u,F as m,d as e,g as B,i as d,v as p,l as b,j as v,k as _,f as g,a as k,t as r,n as T}from"./app.013e25ce.js";import{P as U}from"./Pagination.0b1e04ca.js";const P={components:{AdminLayout:V,Link:D,Pagination:U,Head:L},props:["materials","months"],data(){return{filter:{user_id:route().params.user_id?route().params.user_id:null,doc_name:route().params.doc_name?route().params.doc_name:null,username:route().params.username?route().params.username:null,zhmonth:route().params.zhmonth?route().params.zhmonth:null,zhyear:route().params.zhyear?route().params.zhyear:null,step:route().params.step?route().params.step:null},loading:0,currentDate:new Date}},methods:{getStatusText(o){return o?o==1?"\u049A\u0430\u0440\u0430\u043B\u043C\u0430\u0493\u0430\u043D":o==2?"\u049A\u0430\u0442\u0435 \u0431\u0430\u0440":o==3?"\u0422\u0435\u043A\u0441\u0435\u0440\u0456\u043B\u0433\u0435\u043D":"\u0410\u043D\u044B\u049B\u0442\u0430\u043B\u043C\u0430\u0493\u0430\u043D":"\u049A\u0430\u0442\u0435"},deleteData(o){Swal.fire({title:"\u0416\u043E\u044E\u0493\u0430 \u0441\u0435\u043D\u0456\u043C\u0434\u0456\u0441\u0456\u0437 \u0431\u0435?",text:"\u049A\u0430\u0439\u0442\u044B\u043F \u049B\u0430\u043B\u043F\u044B\u043D\u0430 \u043A\u0435\u043B\u043C\u0435\u0443\u0456 \u043C\u04AF\u043C\u043A\u0456\u043D!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"\u0418\u04D9, \u0436\u043E\u044F\u043C\u044B\u043D!",cancelButtonText:"\u0416\u043E\u049B"}).then(s=>{s.isConfirmed&&this.$inertia.delete(route("admin.materialZhinak.destroy",o))})},search(){this.loading=1;const o=this.clearParams(this.filter);this.$inertia.get(route("admin.materialZhinak.index"),o)}}},S=e("head",null,[e("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 \u0436\u0438\u043D\u0430\u049B")],-1),A={class:"row mb-2"},I=e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"},"\u0416\u0438\u043D\u0430\u049B \u043C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440")],-1),K={class:"col-sm-6"},N={class:"breadcrumb float-sm-right"},F={class:"breadcrumb-item"},M=["href"],Z=e("i",{class:"fas fa-dashboard"},null,-1),H=k(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),j=[Z,H],E=e("li",{class:"breadcrumb-item active"}," \u0416\u0438\u043D\u0430\u049B \u043C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 ",-1),Y={class:"buttons d-flex align-items-center"},q=e("i",{class:"fa fa-trash"},null,-1),G=k(" \u0424\u0438\u043B\u044C\u0442\u0440\u0434\u0456 \u0442\u0430\u0437\u0430\u043B\u0430\u0443 "),J={key:0,class:"spinner-border text-primary mx-3",role:"status"},O=e("span",{class:"sr-only"},"Loading...",-1),Q=[O],R={class:"container-fluid"},W={class:"card"},X={class:"card-body"},$={class:"row"},ee={class:"col-sm-12"},te={class:"table table-hover table-bordered table-striped dataTable dtr-inline"},se=e("tr",{role:"row"},[e("th",null,"\u2116"),e("th",null,"\u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B ID"),e("th",null,"\u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B \u0430\u0442\u0430\u0443\u044B"),e("th",null,"\u0410\u0442\u044B - \u0436\u04E9\u043D\u0456"),e("th",null,"\u0416\u0438\u043D\u0430\u049B \u0430\u0439\u044B(\u0441\u0430\u043D)"),e("th",null,"\u0416\u0438\u043D\u0430\u049B \u0436\u044B\u043B(\u0441\u0430\u043D)"),e("th",null,"\u0421\u0442\u0430\u0442\u0443\u0441"),e("th",null,"\u04D8\u0440\u0435\u043A\u0435\u0442")],-1),ne={class:"filters"},le=e("td",null,null,-1),oe=e("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),re=["value"],ae=e("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),ie=["value"],de=e("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),ue=e("option",{value:"1"}," \u049A\u0430\u0440\u0430\u043B\u043C\u0430\u0493\u0430\u043D ",-1),ce=e("option",{value:"2"}," \u049A\u0430\u0442\u0435 \u0431\u0430\u0440 ",-1),he=e("option",{value:"3"}," \u0422\u0435\u043A\u0441\u0435\u0440\u0456\u043B\u0433\u0435\u043D ",-1),me=[de,ue,ce,he],_e=e("td",null,null,-1),fe={class:"btn-group btn-group-sm"},pe=e("i",{class:"fas fa-edit"},null,-1),be=["onClick"],ve=e("i",{class:"fas fa-times"},null,-1),ge=[ve];function ye(o,s,c,ke,n,l){const y=f("Link"),x=f("Pagination"),w=f("AdminLayout");return a(),i(m,null,[S,h(w,null,{breadcrumbs:u(()=>[e("div",A,[I,e("div",K,[e("ol",N,[e("li",F,[e("a",{href:o.route("admin.index")},j,8,M)]),E])])])]),header:u(()=>[e("div",Y,[h(y,{class:"btn btn-danger",href:o.route("admin.materials.index")},{default:u(()=>[q,G]),_:1},8,["href"]),n.loading?(a(),i("div",J,Q)):B("",!0)])]),default:u(()=>[e("div",R,[e("div",W,[e("div",X,[e("div",$,[e("div",ee,[e("table",te,[e("thead",null,[se,e("tr",ne,[le,e("td",null,[d(e("input",{"onUpdate:modelValue":s[0]||(s[0]=t=>n.filter.user_id=t),class:"form-control",placeholder:"\u049A\u043E\u043B\u0434\u0430\u043D\u0443\u0448\u044B ID",onKeyup:s[1]||(s[1]=b((...t)=>l.search&&l.search(...t),["enter"]))},null,544),[[p,n.filter.user_id]])]),e("td",null,[d(e("input",{"onUpdate:modelValue":s[2]||(s[2]=t=>n.filter.doc_name=t),class:"form-control",placeholder:"\u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B \u0430\u0442\u0430\u0443\u044B",onKeyup:s[3]||(s[3]=b((...t)=>l.search&&l.search(...t),["enter"]))},null,544),[[p,n.filter.doc_name]])]),e("td",null,[d(e("input",{"onUpdate:modelValue":s[4]||(s[4]=t=>n.filter.username=t),class:"form-control",placeholder:"\u0410\u0442\u044B - \u0436\u04E9\u043D\u0456",onKeyup:s[5]||(s[5]=b((...t)=>l.search&&l.search(...t),["enter"]))},null,544),[[p,n.filter.username]])]),e("td",null,[d(e("select",{"onUpdate:modelValue":s[6]||(s[6]=t=>n.filter.zhmonth=t),class:"form-control",placeholder:"\u0416\u0438\u043D\u0430\u049B \u0430\u0439\u044B",onChange:s[7]||(s[7]=_((...t)=>l.search&&l.search(...t),["prevent"]))},[oe,(a(!0),i(m,null,g(c.months,t=>(a(),i("option",{value:t.id,key:"month"+t.id},r(t.month),9,re))),128))],544),[[v,n.filter.zhmonth]])]),e("td",null,[d(e("select",{"onUpdate:modelValue":s[8]||(s[8]=t=>n.filter.zhyear=t),class:"form-control",placeholder:"\u0416\u0438\u043D\u0430\u049B \u0436\u044B\u043B\u044B",onChange:s[9]||(s[9]=_((...t)=>l.search&&l.search(...t),["prevent"]))},[ae,(a(!0),i(m,null,g(n.currentDate.getFullYear()-2020,t=>(a(),i("option",{value:t+2020},r(t+2020),9,ie))),256))],544),[[v,n.filter.zhyear]])]),e("td",null,[d(e("select",{class:"form-control",onChange:s[10]||(s[10]=_(t=>l.search(),["prevent"])),"onUpdate:modelValue":s[11]||(s[11]=t=>n.filter.step=t),placeholder:"\u0421\u0442\u0430\u0442\u0443\u0441"},me,544),[[v,n.filter.step]])]),_e])]),e("tbody",null,[(a(!0),i(m,null,g(c.materials.data,(t,z)=>(a(),i("tr",{class:"odd",key:"material"+t.id},[e("td",null,r(z+1),1),e("td",null,r(t.user.id),1),e("td",null,r(t.doc_name),1),e("td",null,r(t.username),1),e("td",null,r(c.months[t.zhmonth-1].month),1),e("td",null,r(t.zhyear),1),e("td",null,[e("span",{class:T(["badge badge-success",{"badge-success":t.step==3,"badge-danger":t.step==2,"badge-warning":t.step==1}])},r(l.getStatusText(t.step)),3)]),e("td",null,[e("div",fe,[h(y,{href:o.route("admin.materialZhinak.edit",t),class:"btn btn-primary",title:"\u0418\u0437\u043C\u0435\u043D\u0438\u0442\u044C"},{default:u(()=>[pe]),_:2},1032,["href"]),e("button",{onClick:_(xe=>l.deleteData(t.id),["prevent"]),class:"btn btn-danger",title:"\u0416\u043E\u044E"},ge,8,be)])])]))),128))])])])]),h(x,{links:c.materials.links},null,8,["links"])])])])]),_:1})],64)}const Ve=C(P,[["render",ye]]);export{Ve as default};
