<?php
namespace A2bizz\ModuleCreator\Plugin;

class OptionArrayDecorator
{
    protected $escaper;

    public function __construct(
        \Magento\Framework\Escaper $escaper
    ) {
        $this->escaper = $escaper;
    }

    public function afterToOptionArray(\A2bizz\ModuleCreator\Model\Source\IsActive $subject, $result)
    {
        // Modify the $result array as per your requirements
        foreach ($result as &$option) {
            // Modify each option as needed
            // For example, add a prefix to the option label
            if ($option['value']==1):
                //$option['label'] = $this->escaper->escapeHtml(__('<span class="grid-severity-notice"><span>%1</span></span>',$option['label']));
                $option['label'] = __('<span class="grid-severity-notice"><span>%1</span></span>',$option['label']);
            endif;
            if ($option['value']==0):
                //$option['label'] = $this->escaper->escapeHtml(__('<span class="grid-severity-critical"><span>%1</span></span>',$option['label']));
                $option['label'] = __('<span class="grid-severity-critical"><span>%1</span></span>',$option['label']);
            endif;
        }

        return $result;
    }
}