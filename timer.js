const workingTasks = document.querySelectorAll('.working')

workingTasks.forEach((task) => {
  if (task?.classList?.contains('working')) {
    let arr = task.textContent.split('')
    const [hours1, hours2, _, minutes1, minutes2, __, seconds1, seconds2] = arr

    let hours = +(hours1 + hours2)
    let minutes = +(minutes1 + minutes2)
    let seconds = +(seconds1 + seconds2)

    setInterval(() => {
      seconds++

      if (seconds === 60) {
        seconds = 0
        minutes++
      }

      if (minutes === 59 && seconds == 59) {
        hours++
        minutes = 0
        seconds = 0
      }

      const currentTimer = `${hours < 10 ? '0' + hours : hours}:${
        minutes < 10 ? '0' + minutes : minutes
      }:${seconds < 10 ? '0' + seconds : seconds}`

      task.textContent = currentTimer
    }, 1000)
  }
})
