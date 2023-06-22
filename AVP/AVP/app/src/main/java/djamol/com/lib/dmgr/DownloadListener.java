
package djamol.com.lib.dmgr;

/**
 * Download listener, you add many listeners to a download task. And the
 */
public interface DownloadListener {
    /**
     * Download Finish
     * 
     * @param filepath
     */
    void onDownloadFinish(String filepath);

    /**
     * Download Start
     */
    void onDownloadStart();

    /**
     * Download Pause
     */
    void onDownloadPause();

    /**
     * Download Stop
     */
    void onDownloadStop();

    /**
     * Download Fail
     */
    void onDownloadFail();

    /**
     * Download Progress update
     * can be used to display speed and percent.
     * 
     * @param finishedSize
     * @param totalSize
     * @param speed download speed
     */
    void onDownloadProgress(int finishedSize, int totalSize, int speed);
}
