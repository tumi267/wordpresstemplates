(()=>{"use strict";var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var i in o)e.o(o,i)&&!e.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:o[i]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.blocks,o=window.wp.i18n,i=window.wp.apiFetch;var s=e.n(i);const n=window.wp.blockEditor,a=window.wp.components,l=window.wp.data,r=window.wp.element,c=window.ReactJSXRuntime,d=JSON.parse('{"UU":"create-block/dynamic-footer"}');(0,t.registerBlockType)(d.UU,{edit:function({attributes:e,setAttributes:t}){const[i,d]=(0,r.useState)(!0),{phone:_,email:h,address:x,discription:C,twitter:g,linkedin:f,facebook:p,insta:w,logoUrl:m}=e;(0,r.useEffect)((()=>{s()({path:"/wp/v2/settings"}).then((e=>{console.log("Custom Site Attributes:",e.custom_site_attributes),e.custom_site_attributes&&t({phone:e.custom_site_attributes.phone,email:e.custom_site_attributes.email,address:e.custom_site_attributes.address,description:e.custom_site_attributes.description,facebook:e.custom_site_attributes.facebook,insta:e.custom_site_attributes.insta,linkedin:e.custom_site_attributes.linkedin,twitter:e.custom_site_attributes.twitter,logoUrl:e.custom_site_attributes.footer_logoUrl}),d(!1)})).catch((e=>{console.error("Error fetching footer data:",e),d(!1)}))}),[]),(0,r.useEffect)((()=>{i||s()({path:"/wp/v2/settings"}).then((t=>{const o={...t,custom_site_attributes:{...t.custom_site_attributes,phone:e.phone,email:e.email,address:e.address,description:C,facebook:e.facebook,insta:e.insta,linkedin:e.linkedin,twitter:e.twitter,footer_logoUrl:e.logoUrl}};return delete o.site_logo,s()({path:"/wp/v2/settings",method:"POST",data:o})})).then((()=>{console.log("Footer data saved successfully!")})).catch((e=>{console.error("Error saving footer data:",e)}))}),[e]);const j=(0,l.useSelect)((e=>e("core").getEntityRecords("postType","page",{per_page:-1})),[]);return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsxs)(n.InspectorControls,{children:[(0,c.jsxs)("div",{children:[(0,c.jsx)("label",{children:(0,c.jsx)("strong",{children:"Upload Logo:"})}),(0,c.jsx)("input",{type:"file",accept:"image/*",onChange:e=>{const o=e.target.files[0];if(o){const e=new FileReader;e.onload=e=>{const o=e.target.result;t({logoUrl:o})},e.readAsDataURL(o)}}})]}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("phone","footer-phone"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("phone"),value:_||"",onChange:e=>t({phone:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("email","footer-email"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("email"),value:h||"",onChange:e=>t({email:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("address","footer-address"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("address"),value:x||"",onChange:e=>t({address:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("discription","footer-discription"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("discription"),value:C||"",onChange:e=>t({discription:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("facebook","footer-facebook"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("facebook url"),value:p||"",onChange:e=>t({facebook:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("instagram","footer-instagram"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("instagram url"),value:w||"",onChange:e=>t({insta:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("Linkedin","footer-Linkedin"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("Linkedin url"),value:f||"",onChange:e=>t({linkedin:e})})}),(0,c.jsx)(a.PanelBody,{title:(0,o.__)("x","footer-x"),children:(0,c.jsx)(a.TextControl,{__nextHasNoMarginBottom:!0,__next40pxDefaultSize:!0,label:(0,o.__)("x url"),value:g||"",onChange:e=>t({twitter:e})})})]}),(0,c.jsx)("div",{className:"footer_contain",children:(0,c.jsxs)("div",{className:"footer_renderBox",children:[(0,c.jsxs)("div",{className:"footer_contain_discription_content",children:[m&&(0,c.jsx)("img",{id:"footer_logo",src:m,alt:"Logo"}),(0,c.jsx)("div",{children:(0,c.jsx)("p",{className:"footer_discription_text",children:C})}),(0,c.jsxs)("div",{className:"footer_discription_links",children:[""!==p&&(0,c.jsx)("a",{className:"footer_atag",href:p,children:(0,c.jsxs)("svg",{width:"8",height:"15",viewBox:"0 0 8 15",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,c.jsx)("title",{id:"facebook-icon-title",children:"facebook logo"}),(0,c.jsx)("path",{d:"M1.99265 14.5006V7.79444H0.168457L0.168457 5.37991H1.99265V3.31758C1.99265 1.69698 3.0702 0.20874 5.55312 0.20874C6.55842 0.20874 7.30179 0.302423 7.30179 0.302423L7.24321 2.55719C7.24321 2.55719 6.4851 2.55002 5.6578 2.55002C4.76243 2.55002 4.61897 2.95112 4.61897 3.61685V5.37991H7.31439L7.1971 7.79444H4.61897V14.5006H1.99265Z",fill:"white"})]})}),""!==g&&(0,c.jsx)("a",{className:"footer_atag",href:g,children:(0,c.jsxs)("svg",{width:"25",height:"25",viewBox:"0 0 24 24",fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",role:"img","aria-labelledby":"x-icon-title",focusable:"false",children:[(0,c.jsx)("title",{id:"x-icon-title",children:"X logo"}),(0,c.jsx)("path",{d:"M17.5 2H21L13.5 10L22 22H15.5L10.5 15.5L4.5 22H1L9.5 13L1 2H7.5L12 8L17.5 2ZM16.3 20H18.1L6.7 4H4.9L16.3 20Z",fill:"white"})]})}),""!==f&&(0,c.jsx)("a",{className:"footer_atag",href:f,children:(0,c.jsxs)("svg",{width:"17",height:"16",viewBox:"0 0 17 16",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,c.jsx)("title",{id:"linkedin-icon-title",children:"linkedin logo"}),(0,c.jsx)("path",{d:"M3.7924 15.5014V5.16997H0.29059L0.29059 15.5014H3.7924ZM2.04195 3.75854C3.26309 3.75854 4.0232 2.9652 4.0232 1.9738C4.00044 0.960037 3.26314 0.188721 2.06512 0.188721C0.867292 0.188721 0.0839844 0.960052 0.0839844 1.9738C0.0839844 2.96525 0.8439 3.75854 2.01909 3.75854H2.04184H2.04195ZM5.73065 15.5014H9.23246V9.73184C9.23246 9.42306 9.25521 9.1146 9.34768 8.89387C9.60084 8.27694 10.177 7.63797 11.1444 7.63797C12.4115 7.63797 12.9185 8.5854 12.9185 9.97426V15.5014H16.4201V9.5774C16.4201 6.40398 14.6925 4.92742 12.3885 4.92742C10.4994 4.92742 9.66995 5.9629 9.20916 6.66815H9.23254V5.16976H5.73072C5.77668 6.13921 5.73072 15.5012 5.73072 15.5012L5.73065 15.5014Z",fill:"white"})]})}),""!==w&&(0,c.jsx)("a",{className:"footer_atag",href:w,children:(0,c.jsxs)("svg",{width:"17",height:"17",viewBox:"0 0 17 17",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,c.jsx)("title",{id:"instagram-icon-title",children:"instagram logo"}),(0,c.jsx)("path",{d:"M8.75372 4.22655C6.43494 4.22655 4.5646 6.06766 4.5646 8.35021C4.5646 10.6328 6.43494 12.4739 8.75372 12.4739C11.0725 12.4739 12.9428 10.6328 12.9428 8.35021C12.9428 6.06766 11.0725 4.22655 8.75372 4.22655ZM8.75372 11.0311C7.25526 11.0311 6.03024 9.82884 6.03024 8.35021C6.03024 6.87157 7.25161 5.66929 8.75372 5.66929C10.2558 5.66929 11.4772 6.87157 11.4772 8.35021C11.4772 9.82884 10.2522 11.0311 8.75372 11.0311ZM14.0913 4.05787C14.0913 4.59261 13.6538 5.0197 13.1142 5.0197C12.571 5.0197 12.1371 4.58903 12.1371 4.05787C12.1371 3.52671 12.5746 3.09604 13.1142 3.09604C13.6538 3.09604 14.0913 3.52671 14.0913 4.05787ZM16.8658 5.03405C16.8038 3.74563 16.5049 2.60436 15.546 1.66406C14.5908 0.723766 13.4314 0.429475 12.1225 0.364875C10.7735 0.289508 6.73025 0.289508 5.38128 0.364875C4.07605 0.425887 2.91666 0.720177 1.9578 1.66047C0.998931 2.60077 0.703615 3.74204 0.637989 5.03046C0.561426 6.35836 0.561426 10.3385 0.637989 11.6664C0.699969 12.9548 0.998931 14.0961 1.9578 15.0364C2.91666 15.9766 4.07241 16.2709 5.38128 16.3355C6.73025 16.4109 10.7735 16.4109 12.1225 16.3355C13.4314 16.2745 14.5908 15.9802 15.546 15.0364C16.5012 14.0961 16.8002 12.9548 16.8658 11.6664C16.9424 10.3385 16.9424 6.36195 16.8658 5.03405ZM15.1231 13.0912C14.8387 13.7946 14.2882 14.3365 13.5699 14.62C12.4944 15.0399 9.94227 14.943 8.75372 14.943C7.56516 14.943 5.0094 15.0364 3.93751 14.62C3.22292 14.3401 2.67239 13.7982 2.38436 13.0912C1.9578 12.0324 2.05624 9.52019 2.05624 8.35021C2.05624 7.18022 1.96144 4.66439 2.38436 3.60925C2.66874 2.90583 3.21927 2.3639 3.93751 2.08038C5.01304 1.66047 7.56516 1.75737 8.75372 1.75737C9.94227 1.75737 12.498 1.66406 13.5699 2.08038C14.2845 2.36031 14.835 2.90224 15.1231 3.60925C15.5496 4.66798 15.4512 7.18022 15.4512 8.35021C15.4512 9.52019 15.5496 12.036 15.1231 13.0912Z",fill:"white"})]})})]})]}),(0,c.jsxs)("div",{className:"footer_contain_contact_content",children:[(0,c.jsxs)("div",{className:"footer_contain_contact_content_Categories",children:[(0,c.jsx)("h3",{className:"footer_contact_Categories_heading",children:"Categories"}),(0,c.jsx)("ul",{className:"footer_contain_contact_content_Categories_links",children:j?.map((e=>(0,c.jsx)("li",{children:(0,c.jsx)("a",{className:"footer_atag",href:e.link,children:(0,c.jsx)("h3",{className:"footer_atag_text",children:e.title.rendered})})},e.id)))||(0,c.jsx)("p",{children:"Loading Categories..."})})]}),(0,c.jsxs)("div",{className:"footer_contain_contact_content_contact",children:[(0,c.jsx)("h3",{className:"footer_contact_Categories_heading",children:"Contact"}),(0,c.jsxs)("div",{className:"footer_contain_contact_content_Categories_links",children:[(0,c.jsxs)("p",{className:"footer_atag_text",children:[(0,c.jsxs)("svg",{width:"20",height:"21",viewBox:"0 0 20 21",fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",role:"img","aria-labelledby":"phone-icon-title",children:[(0,c.jsx)("title",{id:"phone-icon-title",children:"Phone icon"}),(0,c.jsx)("path",{d:"M0.918081 4.08905L3.46621 1.54332C3.64596 1.36278 3.8596 1.21954 4.09488 1.12181C4.33015 1.02409 4.58241 0.973816 4.83718 0.973877C5.35637 0.973877 5.84446 1.17725 6.21053 1.54332L8.95246 4.28525C9.133 4.465 9.27625 4.67864 9.37397 4.91392C9.47169 5.14919 9.52197 5.40145 9.5219 5.65621C9.5219 6.17541 9.31853 6.6635 8.95246 7.02957L6.94746 9.03458C7.41678 10.069 8.0693 11.0101 8.87351 11.8124C9.6757 12.6186 10.6167 13.2735 11.6513 13.7456L13.6563 11.7406C13.8361 11.5601 14.0497 11.4168 14.285 11.3191C14.5203 11.2214 14.7725 11.1711 15.0273 11.1712C15.5465 11.1712 16.0346 11.3746 16.4007 11.7406L19.145 14.4802C19.3257 14.6602 19.4691 14.8743 19.5668 15.11C19.6646 15.3457 19.7147 15.5984 19.7144 15.8535C19.7144 16.3727 19.5111 16.8608 19.145 17.2269L16.6016 19.7702C16.0178 20.3564 15.2115 20.689 14.3837 20.689C14.209 20.689 14.0415 20.6746 13.8765 20.6459C10.6512 20.1148 7.4523 18.3993 4.87067 15.82C2.29144 13.2432 0.578329 10.0467 0.0399934 6.81184C-0.122705 5.8237 0.205084 4.80684 0.918081 4.08905Z"})]}),(0,c.jsxs)("span",{children:[" ",_]})]}),(0,c.jsxs)("p",{className:"footer_atag_text",children:[(0,c.jsxs)("svg",{width:"21",height:"16",viewBox:"0 0 21 16",fill:"currentColor",xmlns:"http://www.w3.org/2000/svg",role:"img","aria-labelledby":"email-icon-title",children:[(0,c.jsx)("title",{id:"email-icon-title",children:"Email icon"}),(0,c.jsx)("path",{d:"M2.30205 0.838867H18.5335C20.0648 0.838867 20.8365 1.56163 20.8365 3.03165V13.3463C20.8365 14.8041 20.0648 15.5391 18.5335 15.5391H2.30205C0.770783 15.5391 -0.000976563 14.8041 -0.000976562 13.3463V3.03165C-0.000976562 1.56163 0.770783 0.838867 2.30205 0.838867ZM10.4117 11.374L18.6683 4.59967C18.9623 4.35466 19.195 3.79116 18.8275 3.2889C18.4723 2.78664 17.823 2.77439 17.3943 3.08065L10.4117 7.80921L3.44132 3.08065C3.01256 2.77439 2.3633 2.78664 2.00805 3.2889C1.64055 3.79116 1.8733 4.35466 2.1673 4.59967L10.4117 11.374Z"})]}),(0,c.jsxs)("span",{children:[" ",h]})]}),(0,c.jsxs)("p",{className:"footer_atag_text",children:[(0,c.jsx)("svg",{width:"15",height:"20",viewBox:"0 0 15 20",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,c.jsx)("path",{d:"M6.26288 19.4273C4.32008 16.9952 -0.000976563 11.1006 -0.000976562 7.78965C-0.000976562 3.77254 3.19832 0.516113 7.14495 0.516113C11.0901 0.516113 14.2909 3.77254 14.2909 7.78965C14.2909 11.1006 9.93633 16.9952 8.02703 19.4273C7.56924 20.0069 6.72066 20.0069 6.26288 19.4273ZM7.14495 10.2142C8.45876 10.2142 9.52693 9.12692 9.52693 7.78965C9.52693 6.45238 8.45876 5.36514 7.14495 5.36514C5.83114 5.36514 4.76298 6.45238 4.76298 7.78965C4.76298 9.12692 5.83114 10.2142 7.14495 10.2142Z",fill:"white"})}),(0,c.jsxs)("span",{children:[" ",x]})]})]})]})]})]})})]})}})})();