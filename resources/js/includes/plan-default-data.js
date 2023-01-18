const planData = {
    title: 'New Plan',
    description: 'Write something here.',
    unlockType: 'all_content',
    monthlyPricing: 'no',
    monthlyPrice: 0,
    annualPricing: 'no',
    annualPrice: 0,
    action: {
        trigger: 'purchase_plan',
        action: 'add_profile_tag',
        tag: '',
        actionList: []
    }
};

export default planData;