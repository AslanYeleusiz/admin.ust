import{_ as V,A as L}from"./AdminLayout.aacb236b.js";import{L as B,H as j,r as p,o,b as r,e as h,w as c,F as m,d as t,g as U,i as u,v as b,l as v,j as g,k as _,f,a as x,t as a}from"./app.5a1bde93.js";import{P as D}from"./Pagination.8139c795.js";const P={components:{AdminLayout:L,Link:B,Pagination:D,Head:j},props:["materials","materialSubjects","materialDirections","materialClasses"],data(){return{filter:{title:route().params.title?route().params.title:null,description:route().params.description?route().params.description:null,subject:route().params.subject?route().params.subject:null,direction:route().params.direction?route().params.direction:null,class:route().params.class?route().params.class:null},loading:0}},methods:{deleteData(i){Swal.fire({title:"\u0416\u043E\u044E\u0493\u0430 \u0441\u0435\u043D\u0456\u043C\u0434\u0456\u0441\u0456\u0437 \u0431\u0435?",text:"\u049A\u0430\u0439\u0442\u044B\u043F \u049B\u0430\u043B\u043F\u044B\u043D\u0430 \u043A\u0435\u043B\u043C\u0435\u0443\u0456 \u043C\u04AF\u043C\u043A\u0456\u043D!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"\u0418\u04D9, \u0436\u043E\u044F\u043C\u044B\u043D!",cancelButtonText:"\u0416\u043E\u049B"}).then(l=>{l.isConfirmed&&this.$inertia.delete(route("admin.materials.destroy",i))})},search(){this.loading=1;const i=this.clearParams(this.filter);this.$inertia.get(route("admin.materials.index"),i)}}},T=t("head",null,[t("title",null,"\u0410\u0434\u043C\u0438\u043D \u043F\u0430\u043D\u0435\u043B\u044C | \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440")],-1),A={class:"row mb-2"},K=t("div",{class:"col-sm-6"},[t("h1",{class:"m-0"},"\u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456")],-1),N={class:"col-sm-6"},S={class:"breadcrumb float-sm-right"},z={class:"breadcrumb-item"},M=["href"],F=t("i",{class:"fas fa-dashboard"},null,-1),H=x(" \u0411\u0430\u0441\u0442\u044B \u0431\u0435\u0442 "),I=[F,H],E=t("li",{class:"breadcrumb-item active"}," \u041C\u0430\u0442\u0435\u0440\u0438\u0430\u043B\u0434\u0430\u0440 \u0442\u0456\u0437\u0456\u043C\u0456 ",-1),q={class:"buttons d-flex align-items-center"},G=t("i",{class:"fa fa-trash"},null,-1),J=x(" \u0424\u0438\u043B\u044C\u0442\u0440\u0434\u0456 \u0442\u0430\u0437\u0430\u043B\u0430\u0443 "),O={key:0,class:"spinner-border text-primary mx-3",role:"status"},Q=t("span",{class:"sr-only"},"Loading...",-1),R=[Q],W={class:"container-fluid"},X={class:"card"},Y={class:"card-body"},Z={class:"row"},$={class:"col-sm-12"},tt={class:"table table-hover table-bordered table-striped dataTable dtr-inline"},et=t("tr",{role:"row"},[t("th",null,"\u2116"),t("th",null,"\u0422\u0430\u049B\u044B\u0440\u044B\u0431\u044B"),t("th",null,"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A\u0442\u0435\u043C\u0435"),t("th",null,"\u041F\u04D9\u043D"),t("th",null,"\u0411\u0430\u0493\u044B\u0442\u044B"),t("th",null,"\u0421\u044B\u043D\u044B\u043F"),t("th",null,"\u0420\u0430\u0441\u0448\u0438\u0440\u0435\u043D\u0438\u0435"),t("th",null,"\u04D8\u0440\u0435\u043A\u0435\u0442")],-1),lt={class:"filters"},st=t("td",null,null,-1),nt=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),ot=["value"],rt=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),at=["value"],it=t("option",{value:null}," \u0411\u0430\u0440\u043B\u044B\u0493\u044B ",-1),dt=["value"],ut=t("td",null,null,-1),ct={class:"btn-group btn-group-sm"},mt=t("i",{class:"fas fa-edit"},null,-1),ht=["onClick"],_t=t("i",{class:"fas fa-times"},null,-1),ft=[_t];function pt(i,l,d,bt,s,n){const y=p("Link"),w=p("Pagination"),C=p("AdminLayout");return o(),r(m,null,[T,h(C,null,{breadcrumbs:c(()=>[t("div",A,[K,t("div",N,[t("ol",S,[t("li",z,[t("a",{href:i.route("admin.index")},I,8,M)]),E])])])]),header:c(()=>[t("div",q,[h(y,{class:"btn btn-danger",href:i.route("admin.materials.index")},{default:c(()=>[G,J]),_:1},8,["href"]),s.loading?(o(),r("div",O,R)):U("",!0)])]),default:c(()=>[t("div",W,[t("div",X,[t("div",Y,[t("div",Z,[t("div",$,[t("table",tt,[t("thead",null,[et,t("tr",lt,[st,t("td",null,[u(t("input",{"onUpdate:modelValue":l[0]||(l[0]=e=>s.filter.title=e),class:"form-control",placeholder:"\u0422\u0430\u049B\u044B\u0440\u044B\u0431\u044B",onKeyup:l[1]||(l[1]=v((...e)=>n.search&&n.search(...e),["enter"]))},null,544),[[b,s.filter.title]])]),t("td",null,[u(t("input",{"onUpdate:modelValue":l[2]||(l[2]=e=>s.filter.description=e),class:"form-control",placeholder:"\u0422\u04AF\u0441\u0456\u043D\u0456\u043A\u0442\u0435\u043C\u0435",onKeyup:l[3]||(l[3]=v((...e)=>n.search&&n.search(...e),["enter"]))},null,544),[[b,s.filter.description]])]),t("td",null,[u(t("select",{"onUpdate:modelValue":l[4]||(l[4]=e=>s.filter.subject=e),class:"form-control",placeholder:"\u041F\u04D9\u043D\u0456",onChange:l[5]||(l[5]=_((...e)=>n.search&&n.search(...e),["prevent"]))},[nt,(o(!0),r(m,null,f(d.materialSubjects,e=>(o(),r("option",{value:e.name,key:"materialSubject"+e.name},a(e.name),9,ot))),128))],544),[[g,s.filter.subject]])]),t("td",null,[u(t("select",{"onUpdate:modelValue":l[6]||(l[6]=e=>s.filter.direction=e),class:"form-control",placeholder:"\u0411\u0430\u0493\u044B\u0442\u044B",onChange:l[7]||(l[7]=_((...e)=>n.search&&n.search(...e),["prevent"]))},[rt,(o(!0),r(m,null,f(d.materialDirections,e=>(o(),r("option",{value:e.name,key:"materialDirection"+e.name},a(e.name),9,at))),128))],544),[[g,s.filter.direction]])]),t("td",null,[u(t("select",{"onUpdate:modelValue":l[8]||(l[8]=e=>s.filter.class=e),class:"form-control",placeholder:"\u0421\u044B\u043D\u044B\u0431\u044B",onChange:l[9]||(l[9]=_((...e)=>n.search&&n.search(...e),["prevent"]))},[it,(o(!0),r(m,null,f(d.materialClasses,e=>(o(),r("option",{value:e.name,key:"materialClass"+e.name},a(e.name),9,dt))),128))],544),[[g,s.filter.class]])]),t("td",null,[u(t("input",{"onUpdate:modelValue":l[10]||(l[10]=e=>s.filter.raw=e),class:"form-control",placeholder:"docx",onKeyup:l[11]||(l[11]=v((...e)=>n.search&&n.search(...e),["enter"]))},null,544),[[b,s.filter.raw]])]),ut])]),t("tbody",null,[(o(!0),r(m,null,f(d.materials.data,(e,k)=>(o(),r("tr",{class:"odd",key:"material"+e.id},[t("td",null,a(d.materials.from?d.materials.from+k:k+1),1),t("td",null,a(e.title),1),t("td",null,a(e.description),1),t("td",null,a(e.zhanr),1),t("td",null,a(e.zhanr2),1),t("td",null,a(e.zhanr3),1),t("td",null,a(e.raw),1),t("td",null,[t("div",ct,[h(y,{href:i.route("admin.materials.edit",e),class:"btn btn-primary",title:"\u0418\u0437\u043C\u0435\u043D\u0438\u0442\u044C"},{default:c(()=>[mt]),_:2},1032,["href"]),t("button",{onClick:_(vt=>n.deleteData(e.id),["prevent"]),class:"btn btn-danger",title:"\u0416\u043E\u044E"},ft,8,ht)])])]))),128))])])])]),h(w,{links:d.materials.links},null,8,["links"])])])])]),_:1})],64)}const xt=V(P,[["render",pt]]);export{xt as default};