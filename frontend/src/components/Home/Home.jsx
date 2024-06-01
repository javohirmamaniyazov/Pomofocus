import React, { useEffect, useState } from 'react'
import { Navbar, Settings, Tasks, Timer } from '../'
import { ToastContainer } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css';
import TasksService from '../../service/tasks';
import { useSelector } from 'react-redux';
import { useDispatch } from 'react-redux';
import { updateTasks } from '../../slices/tasks';
import SettingsService from '../../service/settings';
import { changeColor, changeColorId, changeNotify, changeNotifyId, getSettingsFinish, getSettingsStart, updateTimer, updateTimerId } from '../../slices/settings';

const Home = () => {
    const [openSettings, setOpenSettings] = useState(false)

    const { currentColor } = useSelector(state => state.settings)
    const { userId, user } = useSelector(state => state.auth)


    const dispatch = useDispatch()

    const getTasks = async () => {
        try {
            const data = await TasksService.getTasks()

            const filteredData = data.filter(item => item.user_id === userId && !item.isDeleted).map(item => ({ ...item, id: String(item.id) }))

            // const orderedData = []

            // filteredData.forEach(task => {
            //     orderedData[task.orderNumber] = task
            // })

            // console.log(orderedData);

            dispatch(updateTasks(filteredData))
        } catch (error) {
            console.error(error);
        }
        dispatch(getSettingsFinish())

    }

    const getTimer = async () => {
        try {
            const res = await SettingsService.getTimer()

            const [filteredTimer] = res.filter(item => item.user_id === userId)

            if (filteredTimer) {

                const newTimer = [
                    {
                        title: "Pomodoro",
                        minute: filteredTimer.pomodoro_time,
                        second: 0,
                    },
                    {
                        title: "Short Break",
                        minute: filteredTimer.short_break_time,
                        second: 0,
                    },
                    {
                        title: "Long Break",
                        minute: filteredTimer.long_break_time,
                        second: 0,
                    },
                ]

                dispatch(updateTimer(newTimer, filteredTimer.id))
                dispatch(updateTimerId(filteredTimer.id))

            }


        } catch (error) {
            console.error(error);
        }
        dispatch(getSettingsFinish())

    }

    const getTheme = async () => {
        try {
            const res = await SettingsService.getTheme()

            const [filteredTheme] = res.filter(item => item.user_id === userId)

            if (filteredTheme) {
                dispatch(changeColor(filteredTheme.color))
                dispatch(changeColorId(filteredTheme.id))
            }
        } catch (error) {
            console.error(error);
        }
        dispatch(getSettingsFinish())

    }

    const getNotify = async () => {

        try {
            const res = await SettingsService.getNotify()

            const [filteredNotify] = res.filter(item => item.user_id === userId)

            if (filteredNotify) {
                dispatch(changeNotify(filteredNotify.minute))
                dispatch(changeNotifyId(filteredNotify.id))
            }
        } catch (error) {
            console.error(error);
        }
        dispatch(getSettingsFinish())
    }

    useEffect(() => {
        dispatch(getSettingsStart())
        getTasks()
        getTimer()
        getTheme()
        getNotify()
    }, [])


    return (
        <div className={`text-center bg-${currentColor}-400 w-[100%] relative `}>
            <div className="w-[700px] mx-auto">
                <Navbar setOpenSettings={setOpenSettings} />
                <div className="w-[500px] mx-auto pt-10 pb-[200px] ">
                    <Timer />
                    <Tasks />

                </div>
            </div>
            {openSettings && <Settings setOpenSettings={setOpenSettings} />}

        </div>
    )
}

export default Home