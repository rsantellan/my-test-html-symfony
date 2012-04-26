<?php
class oneWidgetFormsComponents extends sfComponents {

    public function executeShowSingleForm($request) {
        $this->form = mdAttributeHandler::retrieveFormOfSingleAttribute($this->id, $this->class, $this->profileId, $this->attributeId);
    }
}
