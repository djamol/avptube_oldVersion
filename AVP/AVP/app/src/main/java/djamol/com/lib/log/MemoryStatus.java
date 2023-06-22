package djamol.com.lib.log;

import java.io.File;
import android.os.Environment;
import android.os.StatFs;


public class MemoryStatus
{
    
    private static final int ERROR = -1;
    
    private static final long RESERVED_SIZE = 2097152;
    
    /**
     * 
     */
    private MemoryStatus()
    {
    }
    
    /**
     * 
     * @return is external memory available
     */
    public static boolean externalMemoryAvailable()
    {
        return Environment.getExternalStorageState()
                .equals(Environment.MEDIA_MOUNTED);
    }
    
    /**
     * 
     * @return available internal memory size
     */
    public static long getAvailableInternalMemorySize()
    {
        File path = Environment.getDataDirectory();
        StatFs stat = new StatFs(path.getPath());
        long blockSize = stat.getBlockSize();
        long availableBlocks = stat.getAvailableBlocks();
        return availableBlocks * blockSize;
    }
    
    /**
     * 
     * @return total internal memory size
     */
    public static long getTotalInternalMemorySize()
    {
        File path = Environment.getDataDirectory();
        StatFs stat = new StatFs(path.getPath());
        long blockSize = stat.getBlockSize();
        long totalBlocks = stat.getBlockCount();
        return totalBlocks * blockSize;
    }
    
    /**
     * 
     * @return available external memory size
     */
    public static long getAvailableExternalMemorySize()
    {
        if (externalMemoryAvailable())
        {
            File path = Environment.getExternalStorageDirectory();
            StatFs stat = new StatFs(path.getPath());
            long blockSize = stat.getBlockSize();
            long availableBlocks = stat.getAvailableBlocks();
            return availableBlocks * blockSize;
        }
        else
        {
            return ERROR;
        }
    }
    
    /**
     * 
     * @return total external memory size
     */
    public static long getTotalExternalMemorySize()
    {
        if (externalMemoryAvailable())
        {
            File path = Environment.getExternalStorageDirectory();
            StatFs stat = new StatFs(path.getPath());
            long blockSize = stat.getBlockSize();
            long totalBlocks = stat.getBlockCount();
            return totalBlocks * blockSize;
        }
        else
        {
            return ERROR;
        }
    }
    
    /**
     * 
     * @param size size
     * @return formated string
     */
    public static String formatSize(long size)
    {
        String suffix = "B";
        
        if (size >= 1024)
        {
            suffix = "KiB";
            size /= 1024;
            if (size >= 1024)
            {
                suffix = "MiB";
                size /= 1024;
            }
        }
        
        StringBuilder resultBuffer = new StringBuilder(Long.toString(size));
        
        int commaOffset = resultBuffer.length() - 3;
        while (commaOffset > 0)
        {
            resultBuffer.insert(commaOffset, ',');
            commaOffset -= 3;
        }
        
        if (suffix != null)
        {
            resultBuffer.append(suffix);
        }
        return resultBuffer.toString();
    }
    
    /**
     * 
     * @param size size
     * @return is external memory available
     */
    public static boolean isExternalMemoryAvailable(long size)
    {
        long availableMemory = getAvailableExternalMemorySize();
        return !(size > availableMemory);
    }
    
    /**
     * 
     * @param size  size
     * @return is internal memory available
     */
    public static boolean isInternalMemoryAvailable(long size)
    {
        long availableMemory = getAvailableInternalMemorySize();
        return !(size > availableMemory);
    }
    
    /**
     * 
     * @param size size
     * @return is memory available
     */
    public static boolean isMemoryAvailable(long size)
    {
        size += RESERVED_SIZE;
        if (externalMemoryAvailable())
        {
            return isExternalMemoryAvailable(size);
        }
        return isInternalMemoryAvailable(size);
    }
    
    /**
     * 
     * @param path path
     * @return avaliable specific memory size
     */
    public static long getSpecificMemoryAvaliable(String path)
    {
        StatFs stat = new StatFs(path);
        long blockSize = stat.getBlockSize();
        long availableBlocks = stat.getAvailableBlocks();
        return availableBlocks * blockSize;
    }
    
    /**
     * 
     * @param size size
     * @param path path
     * @return is specific memory available
     */
    public static boolean isSpecificMemoryAvailable(long size, String path)
    {
        long availableMemory = getSpecificMemoryAvaliable(path);
        return !(size > availableMemory);
    }
    
}
