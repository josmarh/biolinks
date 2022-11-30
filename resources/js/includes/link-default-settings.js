
const now = new Date();
const linkDefaultSettings = {
    tempURL: {
        scheduleSwitch: 'no',
        scheduleStart: dformat(now),
        scheduleEnd: dformat(now),
        clickLimit: 5,
        redirectURL: ''
    },
    protection: {
        password: '',
        contentWarning: 'no'
    },
    target: {
        targetType: '',
        country: [],
        device: [],
        browserLang: [],
        os: [],
    }
};

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day} ${time}`;
}

export default linkDefaultSettings;

