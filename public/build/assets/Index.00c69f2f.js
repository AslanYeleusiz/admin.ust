import{_ as L,A as V}from"./AdminLayout.5fa73673.js";import{L as B,H as j,r as p,o,b as a,e as _,w as u,F as c,d as t,g as D,i as m,v as y,l as k,j as b,k as h,f,a as x,t as r}from"./app.013e25ce.js";import{P}from"./Pagination.0b1e04ca.js";const T={components:{AdminLayout:V,Link:B,Pagination:P,Head:j},props:["materials","materialSubjects","materialDirections","materialClasses"],data(){return{filter:{title:route().params.title?route().params.title:null,description:route().params.description?route().params.description:null,subject:route().params.subject?route().params.subject:null,direction:route().params.direction?route().params.direction:null,class:route().params.class?route().params.class:null},loading:0}},methods:{deleteData(i){Swal.fire({title:"\u0416\u043E\u044E\u0493\u0430 \u0441\u0435\u043D\u0456\u043C\u0434\u0456\u0441\u0456\u0437 \u0431\u0435?",text:"\u049A\u0430\u0439\u0442\u044B\u043F \u049B\u0430\u043B\u043F\u044B\u043D\u0430 \u043A\u0435\u043B\u043C\u0435\u0443\u0456 \u043C\u04AF\u043C\u043A\u0456\u043D!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"\u0418\u04D9, \u0436\u043E\u044F\u043C\u044B\u043D!",cancelButtonText:"\u0416\u043E\u049B"}).then(s=>{s.isConfirmed&&this.$inertia.delete(route("admin.materials.destroy",i))})},search(){this.loading=1;const i=this.clearParams(this.filter);this.$inertia.get(route("admin.materials.index"),i)}}},U=t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440")],-1),A={class:"row mb-2"},N=t("div",{class:"col-sm-6"},[t("h1",{class:"m-0"},"\u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456")],-1),S={class:"col-sm-6"},z={class:"breadcrumb float-sm-right"},K={class:"breadcrumb-item"},M=["href"],F=t("i",{class:"fas fa-dashboard"},null,-1),H=x(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),I=[F,H],E=t("li",{class:"breadcrumb-item active"}," \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 ",-1),q={class:"buttons d-flex align-items-center"},G=t("i",{class:"fa fa-trash"},null,-1),J=x(" \u0424\u0438\u043B\u044C\u0442\u0440\u0434\u0456 \u0442\u0430\u0437\u0430\u043B\u0430\u0443 "),O={key:0,class:"spinner-border text-primary mx-3",role:"status"},Q=t("span",{class:"sr-only"},"Loading...",-1),R=[Q],W={class:"container-fluid"},X={class:"card"},Y={class:"card-body"},Z={class:"row"},$={class:"col-sm-12"},tt={class:"table table-hover table-bordered table-striped dataTable dtr-inline"},et=t("tr",{role:"row"},[t("th",null,"\u2116"),t("th",null,"\u0422\u0430\u049B\u044B\u0440\u044B\u0431\u044B"),t("th",null,"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A\u0442\u0435\u043C\u0435"),t("th",null,"\u041F\u04D9\u043D"),t("th",null,"\u0411\u0430\u0493\u044B\u0442\u044B"),t("th",null,"\u0421\u044B\u043D\u044B\u043F"),t("th",null,"\u04D8\u0440\u0435\u043A\u0435\u0442")],-1),st={class:"filters"},lt=t("td",null,null,-1),nt=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),ot=["value"],at=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),rt=["value"],it=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),dt=["value"],ut=t("td",null,null,-1),ct={class:"btn-group btn-group-sm"},mt=t("i",{class:"fas fa-edit"},null,-1),_t=["onClick"],ht=t("i",{class:"fas fa-times"},null,-1),ft=[ht];function pt(i,s,d,bt,l,n){const v=p("Link"),C=p("Pagination"),w=p("AdminLayout");return o(),a(c,null,[U,_(w,null,{breadcrumbs:u(()=>[t("div",A,[N,t("div",S,[t("ol",z,[t("li",K,[t("a",{href:i.route("admin.index")},I,8,M)]),E])])])]),header:u(()=>[t("div",q,[_(v,{class:"btn btn-danger",href:i.route("admin.materials.index")},{default:u(()=>[G,J]),_:1},8,["href"]),l.loading?(o(),a("div",O,R)):D("",!0)])]),default:u(()=>[t("div",W,[t("div",X,[t("div",Y,[t("div",Z,[t("div",$,[t("table",tt,[t("thead",null,[et,t("tr",st,[lt,t("td",null,[m(t("input",{"onUpdate:modelValue":s[0]||(s[0]=e=>l.filter.title=e),class:"form-control",placeholder:"\u0422\u0430\u049B\u044B\u0440\u044B\u0431\u044B",onKeyup:s[1]||(s[1]=k((...e)=>n.search&&n.search(...e),["enter"]))},null,544),[[y,l.filter.title]])]),t("td",null,[m(t("input",{"onUpdate:modelValue":s[2]||(s[2]=e=>l.filter.description=e),class:"form-control",placeholder:"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A\u0442\u0435\u043C\u0435",onKeyup:s[3]||(s[3]=k((...e)=>n.search&&n.search(...e),["enter"]))},null,544),[[y,l.filter.description]])]),t("td",null,[m(t("select",{"onUpdate:modelValue":s[4]||(s[4]=e=>l.filter.subject=e),class:"form-control",placeholder:"\u041F\u04D9\u043D\u0456",onChange:s[5]||(s[5]=h((...e)=>n.search&&n.search(...e),["prevent"]))},[nt,(o(!0),a(c,null,f(d.materialSubjects,e=>(o(),a("option",{value:e.name,key:"materialSubject"+e.name},r(e.name),9,ot))),128))],544),[[b,l.filter.subject]])]),t("td",null,[m(t("select",{"onUpdate:modelValue":s[6]||(s[6]=e=>l.filter.direction=e),class:"form-control",placeholder:"\u0411\u0430\u0493\u044B\u0442\u044B",onChange:s[7]||(s[7]=h((...e)=>n.search&&n.search(...e),["prevent"]))},[at,(o(!0),a(c,null,f(d.materialDirections,e=>(o(),a("option",{value:e.name,key:"materialDirection"+e.name},r(e.name),9,rt))),128))],544),[[b,l.filter.direction]])]),t("td",null,[m(t("select",{"onUpdate:modelValue":s[8]||(s[8]=e=>l.filter.class=e),class:"form-control",placeholder:"\u0421\u044B\u043D\u044B\u0431\u044B",onChange:s[9]||(s[9]=h((...e)=>n.search&&n.search(...e),["prevent"]))},[it,(o(!0),a(c,null,f(d.materialClasses,e=>(o(),a("option",{value:e.name,key:"materialClass"+e.name},r(e.name),9,dt))),128))],544),[[b,l.filter.class]])]),ut])]),t("tbody",null,[(o(!0),a(c,null,f(d.materials.data,(e,g)=>(o(),a("tr",{class:"odd",key:"material"+e.id},[t("td",null,r(d.materials.from?d.materials.from+g:g+1),1),t("td",null,r(e.title),1),t("td",null,r(e.description),1),t("td",null,r(e.zhanr),1),t("td",null,r(e.zhanr2),1),t("td",null,r(e.zhanr3),1),t("td",null,[t("div",ct,[_(v,{href:i.route("admin.materials.edit",e),class:"btn btn-primary",title:"\u0418\u0437\u043C\u0435\u043D\u0438\u0442\u044C"},{default:u(()=>[mt]),_:2},1032,["href"]),t("button",{onClick:h(vt=>n.deleteData(e.id),["prevent"]),class:"btn btn-danger",title:"\u0416\u043E\u044E"},ft,8,_t)])])]))),128))])])])]),_(C,{links:d.materials.links},null,8,["links"])])])])]),_:1})],64)}const xt=L(T,[["render",pt]]);export{xt as default};