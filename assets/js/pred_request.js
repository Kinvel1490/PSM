if(document.querySelector("._stock_status_field")){
    if(document.querySelector("._stock_status_field .select:checked").value !== "onbackorder"){
        document.querySelector("#pred_request").setAttribute("disabled", "");
        Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
            el.setAttribute("disabled", "");
        });
    }
    document.querySelector("._stock_status_field .wc-radios").addEventListener("change", (e)=>{
        if(document.querySelector("._stock_status_field .select:checked").value !== "onbackorder"){
            if(document.querySelector("[name=pred_request_radio_preset]:checked")){
                document.querySelector("[name=pred_request_radio_preset]:checked").checked = false;
                document.querySelector("#pred_request").setAttribute("disabled", "");
                document.querySelector("#pred_request").value = "";
            }
            Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
                el.setAttribute("disabled", "");
            });
        } else {
            Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
                el.removeAttribute("disabled", "");
            });
        }
    });
    Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
        el.addEventListener("change", e=>{
            if(e.target.getAttribute("id") == "pred_request_radio_manual"){
                document.querySelector("#pred_request").removeAttribute("disabled");
            } else {
                document.querySelector("#pred_request").setAttribute("disabled", "");
                document.querySelector("#pred_request").value = "";
            }
        });
    })
}
document.querySelector("#product-type").addEventListener("change", (e)=>{
    if(e.target.value === "variable"){
        Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
            el.removeAttribute("disabled", "");
        });
    } else {
        document.querySelector("#pred_request").setAttribute("disabled", "");
        Array.from(document.querySelectorAll("[name=pred_request_radio_preset]")).forEach(el=>{
            el.setAttribute("disabled", "");
        });
    }
});