import registerFormValidation from  './modules/registerFormValidation'
import populateCstTeam from "./modules/populateCstTeam"
//import populateStates from "./modules/populateStates"

$(function() {
   registerFormValidation()
   populateCstTeam()
   //populateStates()
});